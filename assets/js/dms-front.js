/* global jQuery */

jQuery(document).ready(function () {
  //Change the page on changing of the select

  jQuery(".dms-select").on('change', function () {
    var x = jQuery(this).val();
    if (jQuery(this).hasClass('open-in-new-tab')) {
      window.open(x, '_blank');
    } else {
      if (x !== '') {
        window.location.href = x;
      }
    }
  });
});
