#/bin/sh

uglifyjs ./src/bootstrap-paginator.js -o ./build/bootstrap-paginator.min.js -c sequences=true,dead_code=true,join_vars=true,evaluate=true,conditionals=true,loops=true,unused=false,if_return=true,cascade=true
