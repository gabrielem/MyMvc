<?php
require(rootCoreFunction."_core.php");
require(rootCoreFunction."_routing.php");
require(rootCoreFunction."_filter.php");
require(rootCoreFunction."_filterCheck.php");
require(rootCoreFunction."_filterSet.php");

require(rootCoreFunction."_bcrypt.php");
require(rootCoreFunction."_AUTH.php");

require(rootCoreFunction."updSchema.php");
require(rootCoreFunction."sitemap.php");

## ALL DB FUNCTION
include(rootCoreFunction."validation.php");

//import::_dbFunction("_all_class"); //This it work but for now disabled!
include(rootCoreFunction."db/_all_class.php");
// for compatibility
include(rootCoreFunction."db/delete.php");
include(rootCoreFunction."db/insert.php");
include(rootCoreFunction."db/_loop.php");
include(rootCoreFunction."db/_record.php");
include(rootCoreFunction."db/showTab.php");
include(rootCoreFunction."db/slug.php");
include(rootCoreFunction."db/update.php");
include(rootCoreFunction."db/valiDate.php");

include(rootCoreFunction."forValidation.php");
include(rootCoreFunction."makePagination.php");
include(rootCoreFunction."write.php");
include(rootCoreFunction."getPost.php");
include(rootCoreFunction."IMG.php");
include(rootCoreFunction."russian_numeric_entities.php");
include(rootCoreFunction."virtual_schema.php"); //ONLY IF SCHEMA IS NOT AVAILABLE!!!
include(rootCoreFunction."checkSession.php");
include(rootCoreFunction."_generaForm.php");
include(rootCoreFunction."_htmlHelper.php");
include(rootCoreFunction."ajaxHelper.php");
?>