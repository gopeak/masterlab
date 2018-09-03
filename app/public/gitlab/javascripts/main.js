/* eslint-disable func-names, space-before-function-paren, no-var, quotes, consistent-return, prefer-arrow-callback, comma-dangle, object-shorthand, no-new, max-len, no-multi-spaces, import/newline-after-import, import/first */
/* global Flash */
/* global ConfirmDangerModal */
/* global Aside */

import jQuery from 'jquery'
import _ from 'underscore';
import Cookies from 'js-cookie';
import Dropzone from 'dropzone';
import Sortable from 'sortable';

// libraries with import side-effects
// import '../../dev/lib/mousetrap/mousetrap.min';
// import '../../dev/lib/mousetrap/plugins/pause/mousetrap-pause';
// import 'vendor/fuzzaldrin-plus';

// expose common libraries as globals (TODO: remove these)
window.jQuery = jQuery;
window.$ = jQuery;
window._ = _;
window.Dropzone = Dropzone;
window.Sortable = Sortable;
import './gl_dropdown';
// shortcuts
// import './shortcuts';
// import './shortcuts_blob';
// import './shortcuts_dashboard_navigation';
// import './shortcuts_navigation';
// import './shortcuts_find_file';
// import './shortcuts_issuable';
// import './shortcuts_network';

// templates
import './templates/issuable_template_selector';
import './templates/issuable_template_selectors';

// // commit
import './commit/file';
import './commit/image_file';

// // lib/utils
import './lib/utils/animate';
import './lib/utils/bootstrap_linked_tabs';
import './lib/utils/common_utils';
import './lib/utils/datetime_utility';
import './lib/utils/pretty_time';
import './lib/utils/text_utility';
import './lib/utils/url_utility';

// // behaviors
// import './behaviors/';

// // u2f
import './u2f/authenticate';
import './u2f/error';
import './u2f/register';
import './u2f/util';

// // everything else
// import './abuse_reports';
// import './activities';
// import './admin';
// import './ajax_loading_spinner';
// import './api';
// import './aside';
// import './autosave';
// import loadAwardsHandler from './awards_handler';
// import bp from './breakpoints';
// import './broadcast_message';
// import './build';
// import './build_artifacts';
// import './build_variables';
// import './ci_lint_editor';
// import './commit';
// import './commits';
// import './compare';
// import './compare_autocomplete';
// import './confirm_danger_modal';
// import './copy_as_gfm';
// import './copy_to_clipboard';
// import './create_label';
// import './diff';
// import './dropzone_input';
// import './due_date_select';
// import './files_comment_button';
// import './flash';

// import './gl_field_error';
// import './gl_field_errors';
// import './gl_form';
// import './group_avatar';
// import './group_label_subscription';
// import './groups_select';
// import './header';
// import './importer_status';
// import './issuable_index';
// import './issuable_context';
// import './issuable_form';
// import './issue';
// import './issue_status_select';
// import './label_manager';
// import './labels';
// import './labels_select';
// import './layout_nav';
// import LazyLoader from './lazy_loader';
// import './line_highlighter';
// import './logo';
// import './member_expiration_date';
// import './members';
// import './merge_request';
// import './merge_request_tabs';
// import './milestone';
// import './milestone_select';
// import './mini_pipeline_graph_dropdown';
// import './namespace_select';
// import './new_branch_form';
// import './new_commit_form';
// import './notes';
// import './notifications_dropdown';
// import './notifications_form';
// import './pager';
// import './pipelines';
// import './preview_markdown';
// import './project';
// import './project_avatar';
// import './project_find_file';
// import './project_fork';
// import './project_import';
// import './project_label_subscription';
// import './project_new';
// import './project_select';
// import './project_show';
// import './project_variables';
// import './projects_list';
// import './syntax_highlight';
// import './render_math';
// import './render_gfm';
// import './right_sidebar';
// import './search';
// import './search_autocomplete';
// import './smart_interval';
// import './star';
// import './subscription';
// import './subscription_select';

// import './dispatcher';

// eslint-disable-next-line global-require, import/no-commonjs
// if (process.env.NODE_ENV !== 'production') require('./test_utils/');


