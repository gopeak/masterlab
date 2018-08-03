Sphinx 3.0
===========

Sphinx is a free, dual-licensed search server. Sphinx is written in C++, and focuses on query performance and search relevance.

The primary client API is currently SphinxQL, a dialect of SQL. Almost any MySQL connector should work. Additionally, basic HTTP/JSON API and native APIs for a number of languages (PHP, Python, Ruby, C, Java) are provided.

This document is an effort to build a better documentation for Sphinx 3 and up. Think of it as a book or a tutorial which you would actually *read*; think of the previous "reference manual" as of a "dictionary" where you look up specific syntax features. The two might (and should) eventually converge.


WIP notice
-----------

Sphinx 3 is currently (early 2018) still under active refactoring, so a lot of things might and *will* change in the future.

I will try to mark those as WIP (Work In Progress), but be patient if things in your current build aren't as documented here. That simply means that the behavior already changed but the docs just did not catch up. Do submit a bug report!


Features overview
------------------

Top level picture, what does Sphinx 3 offer?

  * SQL, HTTP/JSON, and a custom (legacy) access APIs
  * NRT (Near Real Time) and offline batch indexing
  * Full-text and non-text (parameter) searching
  * Relevance ranking, from basic formulas to ML models
  * Federated results from multiple servers
  * Decent performance

Other things that seem worth mentioning (this list is probably incomplete at all times, and definitely in random order):

  * Morphology and text-processing tools
    * Fully flexible tokenization (see `charset_table` and `exceptions`)
    * Proper morphology (lemmatizer) for English, Russian, and German (see `morphology`)
    * Basic morphology (stemmer) for many other languages
    * User-specified wordforms, `core 2 duo => c2d`
  * Native JSON support
  * Geosearch support
  * Fast expressions engine
  * Query suggestions
  * Snippets builder
  * ...

And, of course, there is always stuff that we know we currently lack!

  * Index replication
  * ...


Features cheat sheet
---------------------

This section is supposed to provide a bit more detail on all the available features; to cover them more or less fully; and give you some further pointers into the specific reference sections (on the related config directives and SphinxQL statements).

  * Full-text search queries, see `SELECT ... WHERE MATCH('this')` SphinxQL statement
    * Boolean matching operators (implicit AND, explicit OR, NOT, and brackets), as in `(one two) | (three !four)`
    * Boolean matching optimizations, see `OPTION boolean_simplify=1` in `SELECT` statement
    * Advanced text matching operators
      * Field restrictions, `@title hello world` or `@(title,body) any of the two` or `@!title hello` etc
      * In-field position restrictions, `@title[50] hello`
      * MAYBE operator for optional keyword matching, `cat MAYBE dog`
      * phrase matching, `"roses are red"`
      * quorum matching, `"pick any 3 keywords out of this entire set"/3`
      * proximity matching, `"within 10 positions all keywords in yoda order"~10` or `hello NEAR/3 world NEAR/4 "my test"`
      * strict order matching, `(bag of words) << "exact phrase" << red|green|blue`
      * sentence matching, `all SENTENCE words SENTENCE "in one sentence"`
      * paragraph matching, `"Bill Gates" PARAGRAPH "Steve Jobs"`
      * zone and zone-span matching, `ZONE:(h3,h4) in any of these title tags` and `ZONESPAN:(h2) only in a single instance`
    * Keyword modifiers (that can usually be used within operators)
      * exact (pre-morphology) form modifier, `raining =cats and =dogs`
      * field-start and field-end modifiers, `^hello world$`
      * IDF (ranking) boost, `boosted^1.234`
    * Substring and wildcard searches
      * see `min_prefix_len` and `min_infix_len` directives
      * use `th?se three keyword% wild*cards *verywher*` (`?` = 1 char exactly; `%` = 0 or 1 char; `*` = 0 or more chars)
  * ...

TODO: describe more, add links!


Getting started
----------------

That should now be rather simple. No magic installation required! On any platform, the *sufficient* thing to do is:

  1. Get the binaries.
  2. Run `searchd`
  3. Create indexes.
  4. Run queries.

Or alternatively, you can ETL your data offline, using the `indexer` tool:

  1. Get the binaries.
  2. Create `sphinx.conf`
  3. Run `indexer --all` once, to initially create the indexes.
  4. Run `searchd`
  5. Run queries.
  6. Run `indexer --all --rotate` regularly, to update the indexes.

Note that instead of inserting the data into indexes online, the `indexer` tool instead creates a shadow copy of the specified index(es) offline, and then sends a signal to `searchd` to pick up that copy. So you should *never* get a partially populated index with `indexer`; it's always all-or-nothing.

### Getting started on Linux (and MacOS)

Versions and file names *will* vary, and you most likely *will* want to configure Sphinx at least a little, but for an immediate quickstart:

```bash
$ wget -q http://sphinxsearch.com/files/sphinx-3.0.2-2592786-linux-amd64.tar.gz
$ tar zxf sphinx-3.0.2-2592786-linux-amd64.tar.gz
$ cd sphinx-3.0.2-2592786-linux-amd64/bin
$ ./searchd
Sphinx 3.0.2 (commit 2592786)
Copyright (c) 2001-2018, Andrew Aksyonoff
Copyright (c) 2008-2016, Sphinx Technologies Inc (http://sphinxsearch.com)

listening on all interfaces, port=9312
listening on all interfaces, port=9306
WARNING: No extra index definitions found in data folder
$
```

That's it; the daemon should now be running and accepting connections on port 9306. And you can connect to it using MySQL CLI (see below for more details, or just try `mysql -P9306` right away).

### Getting started on Windows

Pretty much the same story, except that on Windows `searchd` will not automatically go into background:

```
C:\Sphinx\>searchd.exe
Sphinx 3.0-dev (c3c241f)
...
accepting connections
prereaded 0 indexes in 0.000 sec
```

This is alright. Do not kill it. Just switch to a separate session and start querying.
	
### Running queries via MySQL shell

Run the MySQL CLI and point it to a port 9306. For example on Windows:

```
C:\>mysql -h127.0.0.1 -P9306
Welcome to the MySQL monitor.  Commands end with ; or \g.
Your MySQL connection id is 1
Server version: 3.0-dev (c3c241f)
...
```

I have intentionally used `127.0.0.1` in this example for two reasons (both caused by MySQL CLI quirks, not Sphinx):

  * sometimes, an IP address is required to use the `-P9306` switch, not `localhost`
  * sometimes, `localhost` works but causes a connection delay

But in the simplest case even just `mysql -P9306` should work fine.

And from there, just run SphinxQL queries:

```sql
mysql> CREATE TABLE test (gid integer, title field stored, content field stored);
Query OK, 0 rows affected (0.00 sec)

mysql> INSERT INTO test (id, title) VALUES (123, 'hello world');
Query OK, 1 row affected (0.00 sec)

mysql> INSERT INTO test (id, gid, content) VALUES (234, 345, 'empty title');
Query OK, 1 row affected (0.00 sec)

mysql> SELECT * FROM test;
+------+------+-------------+-------------+
| id   | gid  | title       | content     |
+------+------+-------------+-------------+
|  123 |    0 | hello world |             |
|  234 |  345 |             | empty title |
+------+------+-------------+-------------+
2 rows in set (0.00 sec)

mysql> SELECT * FROM test WHERE MATCH('hello');
+------+------+-------------+---------+
| id   | gid  | title       | content |
+------+------+-------------+---------+
|  123 |    0 | hello world |         |
+------+------+-------------+---------+
1 row in set (0.00 sec)

mysql> SELECT * FROM test WHERE MATCH('@content hello');
Empty set (0.00 sec)

```

SphinxQL is our own SQL dialect. More details on the supported statements are currently available in 2.x docs, see [SphinxQL Reference](sphinx2.html#sphinxql-reference)

### Running queries from PHP, Python, etc

```php
<?php

$conn = mysqli_connect("127.0.0.1:9306", "", "", "");
if (mysqli_connect_errno())
	die("failed to connect to Sphinx: " . mysqli_connect_error());

$res = mysqli_query($conn, "SHOW VARIABLES");
while ($row = mysqli_fetch_row($res))
	print "$row[0]: $row[1]\n";
```

TODO: examples

### Running queries via HTTP

TODO: examples

### Installing `indexer` SQL drivers on Linux

This only affects `indexer` ETL tool only. If you never bulk load data from SQL
sources using it (of course CSV and XML sources are still fine), you can safely
skip this section. (And on Windows all the drivers come with the package.)

Depending on your OS, the required package names may vary. Here are some
current (as of Mar 2018) package names for Ubuntu and CentOS:

```bash
ubuntu$ apt-get install libmysqlclient-dev libpq-dev unixodbc-dev
ubuntu$ apt-get install libmariadb-client-lgpl-dev-compat

centos$ yum install mariadb-devel postgresql-devel unixODBC-devel
```

Why might these be needed, and how they work?

`indexer` natively supports MySQL (or MariaDB), PostgreSQL, and UnixODBC
drivers. Meaning it can natively connect to those databases, run SQL queries,
extract results, and create full-text indexes from that. Binaries now always
come with that *support* enabled.

However, you still need to have a specific driver *library* installed on your
system, so that `indexer` could dynamically load it, and access the database.
Depending on the specific database and OS you use, the package names might be
different, but here go a few common pointers.

The driver libraries are loaded by name. The following names are attempted:

  * MySQL: `libmysqlclient.so` or `libmariadb.so`
  * PostgreSQL: `libpq.so`
  * ODBC: `libodbc.so`

To support MacOS, `.dylib` extension (in addition to `.so`) is also tried.


Changes since 2.x
------------------

> WIP: the biggest change to rule them all is yet to come. The all new, fully RT index format is still in progress, and not yet available. Do not worry, ETL via `indexer` will *not* be going anywhere. Moreover, despite being fully and truly RT, the new format is actually already *faster* at batch indexing.

The biggest changes since Sphinx 2.x are:

  * added DocStore, document storage
    * original document contents can now be stored into the index
    * disk based storage, RAM footprint should be minimal
    * goodbye, *having* to query Another Database to fetch data
  * added new attributes storage format
    * arbitrary updates support (including MVA and JSON)
    * goodbye, sudden size limits
  * added attribute indexes, with JSON support
    * ... `WHERE gid=123` queries can now utilize A-indexes
    * ... `WHERE MATCH('hello') AND gid=123` queries can now efficiently intersect FT-indexes and A-indexes
    * goodbye, *having* to use fake keywords
  * added compressed JSON keys
  * switched to rowids internally, started to remove hard requirements on docids
    * docids are now always 64-bit (no different builds), and can be negative or zero
    * docids are still required, and supposed to be unique, but
    * internally, they are not required anymore

Another two big changes that are already available but still in pre-alpha are:

  * added "zero config" mode
  * added index replication

The additional smaller niceties are:

  * added always-on support for xmlpipe, snowball stemmers, and re2 (regexp filters)
  * added `blend_mode=prefix_tokens`, and enabled empty `blend_mode`
  * added `kbatch_source` directive, to auto-generate k-batches from source docids (in addition to explicit queries)
  * added `SHOW OPTIMIZE STATUS` statement
  * added `exact_field_hit` ranking factor
  * added `123.45f` value syntax in JSON, optimized support for float32 vectors, and `FVEC()` and `DOT()` functions
  * added preindexed data in document storage to speed up `SNIPPETS()` (via `hl_fields` directive)
  * changed field weights, zero and negative weights are now allowed
  * changed stemming, keywords with digits are now excluded

A bunch of legacy things were removed:

  * removed `dict`, `docinfo`, `infix_fields`, `prefix_fields` directives
  * removed `attr_flush_period`, `hit_format`, `hitless_words`, `inplace_XXX`, `max_substring_len`, `mva_updates_pool`, `phrase_boundary_XXX`, `sql_joined_field`, `subtree_XXX` directives
  * removed legacy id32 and id64 modes, mysqlSE plugin, and `indexer --keep-attrs` switch

And last but not least, the new config directives to play with are:

  * `docstore_type`, `docstore_block`, `docstore_comp`, `docstore_cache_size` (per-index) let you generally configure DocStore
  * `stored_fields`, `stored_only_fields`, `hl_fields` (per-index) let you configure what to put in DocStore
  * `kbatch`, `kbatch_source` (per-index) update the legacy k-lists-related directives
  * `updates_pool` (per-index) sets vrow file growth step
  * `json_packed_keys` (`common` section) enables the JSON keys compression
  * `binlog_flush_mode` (`searchd` section) changes the per-op flushing mode (0=none, 1=fsync, 2=fwrite)

Quick update caveats:

  * if you were using `sql_query_killlist` then you now *must* explicitly specify `kbatch` and list all the indexes that the k-batch should be applied to:

```sql
sql_query_killlist = SELECT deleted_id FROM my_deletes_log
kbatch = main

# or perhaps:
# kbatch = shard1,shard2,shard3,shard4
```


Changes in 3.x
---------------

### Version 3.0.3, 30 mar 2018

* added `BITCOUNT()` function and bitwise-NOT operator, eg `SELECT BITCOUNT(~3)`
* made `searchd` config section completely optional
* improved min_infix_len behavior, internally required minimum of 2 is now enforced
* improved docs, added a few sections
* fixed binary builds performance
* fixed several crashes (related to docstore, snippets, threading, json_packed_keys in RT)
* fixed docid-less SQL sources, forbidden those for now (docid still required)
* fixed int-vs-float precision issues in expressions in certain cases
* fixed "uptime" counter in `SHOW STATUS`
* fixed query cache vs `PACKEDFACTORS()`

### Version 3.0.2, 25 feb 2018

* added `full_field_hit` ranking factor
* added `bm15` ranking factor name (legacy `bm25` name misleading, to be removed)
* optimized RT inserts significantly (upto 2-6x on certain benchmarks vs 3.0.1)
* optimized `exact_field_hit` ranking factor, impact now negligible (approx 2-4%)
* improved `indexer` output, less visual noise
* improved `searchd --safetrace` option, now skips `addr2line` to avoid occasional freezes
* improved `indexer` MySQL driver lookup, now also checking for `libmariadb.so`
* fixed rare occasional `searchd` crash caused by attribute indexes
* fixed `indexer` crash on missing SQL drivers, and improved error reporting
* fixed `searchd` crash on multi-index searches with docstore
* fixed that expression parser failed on field-shadowing attributes in BM25F() weights map
* fixed that ALTER failed on field-shadowing attributes vs index_field_lengths case
* fixed junk data writes (seemingly harmless but anyway) in certain cases
* fixed rare occasional `searchd` startup failures (threading related)

### Version 3.0.1, 18 dec 2017

* first public release of 3.x branch


Main concepts
--------------

Alas, many projects tend to reinvent their own dictionary, and Sphinx is no exception. Sometimes that probably creates confusion for no apparent reason. For one, what SQL guys call "tables" (or even "relations" if they are old enough to remember Edgar Codd), and MongoDB guys call "collections", we the text search guys tend to call "indexes", and not really out of mischief and malice either, but just because for us, those things *are* primarily FT (full-text) indexes. Thankfully, most of the concepts are close enough, so our personal little Sphinx dictionary is tiny. Let's see.

Short cheat-sheet!

| Sphinx             | Closest SQL equivalent                   |
|--------------------|------------------------------------------|
| Index              | Table                                    |
| Document           | Row                                      |
| Field or attribute | Column and/or a FULLTEXT index           |
| Indexed field      | *Just* a FULLTEXT index on a text column |
| Stored field       | Text column *and* a FULLTEXT index on it |
| Attribute          | Column                                   |
| MVA                | Column with an INT_SET type              |
| JSON attribute     | Column with a JSON type                  |
| Attribute index    | Index                                    |
| Document ID, docid | Column called "id", with a BIGINT type   |
| Row ID, rowid      | Internal Sphinx row number               |

And now for a little more elaborate explanation.

### Indexes

Sphinx indexes are semi-structured collections of documents. They may seem closer to SQL tables than to Mongo collections, but in their core, they really are neither. The primary, foundational data structure here is a *full-text index*. It is a special structure that lets us respond very quickly to a query like "give me the (internal) identifiers of all the documents that mention This or That keyword". And everything else (any extra attributes, or document storage, or even the SQL or HTTP querying dialects, and so on) that Sphinx provides is essentially some kind of an addition on top of that base data structure. Well, hence the "index" name.

Schema-wise, Sphinx indexes try to combine the best of schemaful and schemasless worlds. For "columns" where you know the type upfront, you can use the statically typed attributes, and get the absolute efficiency. For more dynamic data, you can put it all into a JSON attribute, and still get quite decent performance.

So in a sense, Sphinx indexes == SQL tables, except (a) full-text searches are fast and come with a lot of full-text-search specific tweaking options; (b) JSON "columns" (attributes) are quite natively supported, so you can go schemaless; and (c) for full-text indexed fields, you can choose to store *just* the full-text index and ditch the original values.

### Documents

Documents are essentially just a list of named text fields, and arbitrary-typed attributes. Quite similar to SQL rows; almost indistiguishable, actually.

As of 3.0.1, Sphinx still requires a unique `id` attribute, and implicitly injects an `id BIGINT` column into indexes (as you probably noticed in the [Getting started](#getting-started) section). We still use those docids to identify specific rows in `DELETE` and other statements. However, unlike in 2.x, we no longer use docids to identify documents internally. Thus, zero and negative docids are already allowed.

> WIP: full proper support for indexes without an `id` column is planned; ditto auto-generated docids.

### Fields

Fields are the texts that Sphinx indexes and makes keyword-searchable. They always are *indexed*, as in full-text indexed. Their original, unindexed contents can also be *stored* into the index for later retrieval. By default, they are not, and Sphinx is going to return attributes only, and *not* the contents. However, if you explicitly mark them as stored (either with a `stored` flag in `CREATE TABLE` or in the ETL config file using `stored_fields` directive), you can also fetch the fields back:

```sql
mysql> CREATE TABLE test1 (title field);
mysql> INSERT INTO test1 VALUES (123, 'hello');
mysql> SELECT * FROM test1 WHERE MATCH('hello');
+------+
| id   |
+------+
|  123 |
+------+
1 row in set (0.00 sec)

mysql> CREATE TABLE test2 (title field stored);
mysql> INSERT INTO test2 VALUES (123, 'hello');
mysql> SELECT * FROM test2 WHERE MATCH('hello');
+------+-------+
| id   | title |
+------+-------+
|  123 | hello |
+------+-------+
1 row in set (0.00 sec)
```

Stored fields contents are stored in a special index component called document storage, or DocStore for short.

### Attributes

Sphinx supports the following attribute types:

  * INTEGER, unsigned 32-bit integer
  * BIGINT, signed 64-bit integer
  * FLOAT, 32-bit (single precision) floating point
  * BOOL, 1-bit boolean
  * STRING, a text string
  * JSON, a JSON document
  * MVA, an order-insensitive set of unique INTEGERs
  * MVA64, an order-insensitive set of unique BIGINTs

All of these should be pretty straightforward. However, there are a couple Sphinx specific JSON performance tricks worth mentioning:

  * All scalar values (integers, floats, doubles) are converted and internally stored natively.
  * All scalar value *arrays* are detected and also internally stored natively.
  * You can use `123.45f` syntax extension to mark 32-bit floats (by default all floating point values in JSON are 64-bit doubles).

For example, when the following document is stored into a JSON column in Sphinx:
```json
{"title":"test", "year":2017, "tags":[13,8,5,1,2,3]}
```
Sphinx detects that the "tags" array consists of integers only, and stores the array data using 24 bytes exactly, using just 4 bytes per each of the 6 values. Of course, there still are the overheads of storing the JSON keys, and the general document structure, so the *entire* document will take more than that. Still, when it comes to storing bulk data into Sphinx index for later use, just provide a consistently typed JSON array, and that data will be stored - and processed! - with maximum efficiency.

Attributes are supposed to fit into RAM, and Sphinx is optimized towards that case. Ideally, of course, all your index data should fit into RAM, while being backed by a fast enough SSD for persistence.

Now, there are *fixed-width* and *variable-width* attributes among the supported types. Naturally, scalars like INTEGER and FLOAT will always occupy exactly 4 bytes each, while STRING and JSON types can be as short as, well, empty; or as long as several megabytes. How does that work internally? Or in other words, why don't I just save everything as JSON?

The answer is performance. Internally, Sphinx has two separate storages for those row parts. Fixed-width attributes, including hidden system ones, are essentially stored in big static NxM matrix, where N is the number of rows, and M is the number of fixed-width attributes. Any accesses to those are very quick. All the variable-width attributes for a single row are grouped together, and stored in a separate storage. A single offset into that second storage (or "vrow" storage, short for "variable-width row part" storage) is stored as hidden fixed-width attribute. Thus, as you see, accessing a string or a JSON or an MVA value, let alone a JSON key, is somewhat more complicated. For example, to access that `year` JSON key from the example just above, Sphinx would need to:

  * read `vrow_offset` from a hidden integer attribute
  * access the vrow part using that offset
  * decode the vrow, and find the needed JSON attribute start
  * decode the JSON, and find the `year` key start
  * check the key type, just in case it needs conversion to integer
  * finally, read the `year` value

Of course, optimizations are done on every step here, but still, if you access a *lot* of those values (for sorting or filtering the query results), there will be a performance impact. Also, the deeper the key is buried into that JSON, the worse. For example, using a tiny test with 1,000,000 rows and just 4 integer attributes plus exactly the same 4 values stored in a JSON, computing a sum yields the following:

| Attribute    | Time      | Slowdown  |
|--------------|-----------|-----------|
| Any INT      | 0.032 sec | -         |
| 1st JSON key | 0.045 sec | 1.4x      |
| 2nd JSON key | 0.052 sec | 1.6x      |
| 3rd JSON key | 0.059 sec | 1.8x      |
| 4th JSON key | 0.065 sec | 2.0x      |

And with more attributes it would eventually slowdown even worse than 2x times, especially if we also throw in more complicated attributes, like strings or nested objects.

So bottom line, why not JSON everything? As long as your queries only touch a handful of rows each, that is fine, actually! However, if you have a *lot* of data, you should try to identify some of the "busiest" columns for your queries, and store them as "regular" typed columns, that somewhat improves performance.


Using DocStore
---------------

Storing fields into your indexes is easy, just list those fields in a `stored_fields` directive and you're all set:

```
index mytest
{
	type = rt
	path = data/mytest

	rt_field = title
	rt_field = content
	stored_fields = title, content
	# hl_fields = title, content

	rt_attr_uint = gid
}
```

Let's check how that worked:

```
mysql> desc mytest;
+---------+--------+-----------------+------+
| Field   | Type   | Properties      | Key  |
+---------+--------+-----------------+------+
| id      | bigint |                 |      |
| title   | field  | indexed, stored |      |
| content | field  | indexed, stored |      |
| gid     | uint   |                 |      |
+---------+--------+-----------------+------+
4 rows in set (0.00 sec)

mysql> insert into mytest (id, title) values (123, 'hello world');
Query OK, 1 row affected (0.00 sec)

mysql> select * from mytest where match('hello');
+------+------+-------------+---------+
| id   | gid  | title       | content |
+------+------+-------------+---------+
|  123 |    0 | hello world |         |
+------+------+-------------+---------+
1 row in set (0.00 sec)
```

Yay, original document contents! Not a huge step generally, not for a database anyway; but a nice improvement for Sphinx which was initially designed "for searching only" (oh, the mistakes of youth). And DocStore can do more than that, namely:

  * store indexed fields, `store_fields` directive
  * store unindexed fields, `stored_only_fields` directive
  * store precomputed data to speedup snippets, `hl_fields` directive
  * be fine-tuned a little, using `docstore_type`, `docstore_comp`, and `docstore_block` directives

So DocStore can effectively replace the existing `rt_field_string` directive. What are the differences, and when to use each?

`rt_field_string` creates an *attribute*, uncompressed, and stored in RAM. Attributes are supposed to be small, and suitable for filtering (WHERE), sorting (ORDER BY), and other operations like that, by the millions. So if you really need to run queries like ... WHERE title='abc', or in case you want to update those strings on the fly, you will still need attributes. 

But complete original document contents are rather rarely accessed in *that* way! Instead, you usually need just a handful of those, in the order of 10s to 100s, to have them displayed in the final search results, and/or create snippets. DocStore is designed exactly for that. It compresses all the data it receives (by default), and tries to keep most of the resulting "archive" on disk, only fetching a few documents at a time, in the very end.

Snippets become pretty interesting with DocStore. You can generate snippets from either specific stored fields, or the entire document, or a subdocument, respectively:

```sql
SELECT id, SNIPPET(title, QUERY()) FROM mytest WHERE MATCH('hello')
SELECT id, SNIPPET(DOCUMENT(), QUERY()) FROM mytest WHERE MATCH('hello')
SELECT id, SNIPPET(DOCUMENT({title}), QUERY()) FROM mytest WHERE MATCH('hello')
```

Using `hl_fields` can accelerate highlighting where possible, sometimes making snippets *times* faster. If your documents are big enough (as in, a little bigger than tweets), try it! Without `hl_fields`, SNIPPET() function will have to reparse the document contents every time. With it, the parsed representation is compressed and stored into the index upfront, trading off a not-insignificant amount of CPU work for more disk space, and a few extra disk reads.

And speaking of disk space vs CPU tradeoff, these tweaking knobs let you fine-tune DocStore for specific indexes:

  * `docstore_type = vblock_solid` (default) groups small documents into a single compressed block, upto a given limit: better compression, slower access
  * `docstore_type = vblock` stores every document separately: worse compression, faster access
  * `docstore_block = 16k` (default) lets you tweak the block size limit
  * `docstore_comp = lz4hc` (default) uses LZ4HC algorithm for compression: better compression, but slower
  * `docstore_comp = lz4` uses LZ4 algorithm: worse compression, but faster
  * `docstore_comp = none` disables compression


Using attribute indexes
------------------------

Quick kickoff: we now have `CREATE INDEX` statement, and sometimes it *does* make your queries faster!

```sql
CREATE INDEX i1 ON mytest(group_id)
DESC mytest
SELECT * FROM mytest WHERE group_id=1
SELECT * FROM mytest WHERE group_id BETWEEN 10 and 20
SELECT * FROM mytest WHERE MATCH('hello world') AND group_id=23
DROP INDEX i1 ON mytest
```

Point reads, range reads, and intersections between `MATCH()` and index reads are all intended to work. Moreover, `GEODIST()` can also automatically use indexes (see more below). One of the goals is to completely eliminate the need to insert "fake keywords" into your index. (Also, it's possible to *update* attribute indexes on the fly, as opposed to indexed text.)

Indexes on JSON keys should also work, but you might need to cast them to a specific type when creating the index:
```sql
CREATE INDEX j1 ON mytest(j.group_id)
CREATE INDEX j2 ON mytest(INTEGER(j.year))
CREATE INDEX j3 ON mytest(FLOAT(j.latitude))
```

As of version 3.0.2, attribute indexes can only be created on RT indexes. However, you can *instantly* convert your plain indexes to RT by using `ATTACH ... WITH TRUNCATE`, and run `CREATE INDEX` after that, as follows:
```sql
ATTACH INDEX myplain TO myrt WITH TRUNCATE
CREATE INDEX date_added ON myrt(date_added)
```

A rather important optimization of `GEODIST()` automatically kicks in when you (a) use the form with 2 columns and 2 constants, and (b) then use the result in a filter, as follows:
```sql
SELECT *, GEODIST(lat,lon,55.7540,37.6206,{in=deg,out=km}) AS dist
  FROM myindex WHERE dist<=100
```
In this example, the query optimizer will automatically compute the approximate bounding box (ie. minimum and maximum possible `lat` and `lon` values that are within the 100 km distance), and utilize the indexes on both `lat` and `lon` columns if they are available, and even intersect the index read results first if the indexes on *both* columns exist. For small distances (ie. within one city or so), the speedup is usually huge. Also note that in a slightly different query the optimization might *not* trigger, for example:
```sql
SELECT *, GEODIST(lat,lon,55.7540,37.6206,{in=deg,out=km})<=100 AS bad_dist_flag
  FROM myindex WHERE bad_dist_flag=1
```
This is because the `WHERE` optimizer is a simpleton! It does not go too deep, and basically while in the first case it can immediately "sees" that `dist` is actually a `GEODIST()` and then examines it further, in the second case it only "sees" some kind of an arbitrary expression, and stops there.


TODO: describe more!


Using k-batches
----------------

K-batches ("kill batches") let you bulk delete older versions of the documents (rows) when bulk loading new data into Sphinx, for example, adding a new delta index on top of an older main archive index.

K-batches in Sphinx 3 replace k-lists ("kill lists") from 2.x and before. The major differences are that:

  1. They are *not* anonymous anymore.
  2. They are now only applied once on loading. (As oppposed to every search, yuck).

"Not anonymous" means that when loading a new index with an associated k-batch into `searchd`, **you now have to explicitly specify target indexes** that it should delete the rows from. In other words, "deltas" now *must* explicitly specify all the "main" indexes that they want to erase old documents from, at index-time.

The effect of applying a k-batch is equivalent to running (just once) a bunch of DELETE FROM X WHERE id=Y queries, for every index X listed in `kbatch` directive, and every document id Y stored in the k-batch. With the index format updates this is now both possible, **even in "plain" indexes**, and quite efficient too.

K-batch only gets applied once. After a succesful application to all the target indexes, the batch gets cleared.

So, for example, when you load an index called `delta` with the following settings:

```
index delta
{
	...
	sql_query_kbatch = SELECT 12 UNION SELECT 13 UNION SELECT 14
	kbatch = main1, main2
}
```

The following (normally) happens:

  * `delta` kbatch file is loaded
    * in this example it will have 3 document ids: 12, 13, and 14
  * documents with those ids are deleted from `main1`
  * documents with those ids are deleted from `main2`
  * `main1`, `main2` save those deletions to disk
  * if all went well, `delta` kbatch file is cleared

All these operations are pretty fast, because deletions are now internally implemented using a bitmap. So deleting a given document by id results in a hash lookup and a bit flip. In plain speak, very quick.

"Loading" can happen either by restarting or rotation or whatever, k-batches should still try to apply themselves.

Last but not least, you can also use `kbatch_source` to avoid explicitly storing all newly added document ids into a k-batch, instead, you can use `kbatch_source = kl, id` or just `kbatch_source = id`; this will automatically add all the document ids from the index to its k-batch. The default value is `kbatch_source = kl`, that is, to use explicitly provided docids only.


Doing bulk data loads
----------------------

TODO: describe rotations (legacy), RELOAD, ATTACH, etc.


Using JSON
-----------

TODO: describe limits, key count impact, key compression, all the json_xxx settings, etc.


Copyrights
-----------

This documentation is copyright (c) 2017-2018, Andrew Aksyonoff. The author hereby grants you the right to redistribute it in a verbatim form, along with the respective copy of Sphinx it came bundled with. All other rights are reserved.
