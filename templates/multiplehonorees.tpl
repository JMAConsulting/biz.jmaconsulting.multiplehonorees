<div id="multiplehonorees" class="crm-public-form-item crm-group custom_post_profile-group">
  <div class="crm-public-form-item crm-group">
    <fieldset><legend>{ts}Gift of Family Card Campaign Details{/ts}</legend>
      <div class="crm-section">
        <div class="label">
          {$form.referred_by.label}
        </div>
        <div class="content">
          {$form.referred_by.html}
        </div>
      </div>
      <br/>
      <div class="crm-section">
        <div class="label">
          {$form.total_card.label}
        </div>
        <div class="content">
          {$form.total_card.html}<br><sub>* If requesting multiple card</sub>
        </div>
      </div>
      <br/>
      <div class="crm-section">
        <div class="label">
          {$form.each_gift_amount.label}
        </div>
        <div class="content">
          {$form.each_gift_amount.html}<br><sub>* If requesting multiple card</sub>
        </div>
      </div>
  </div>
  {section name='i' start=1 loop=25}
    {assign var='rowNumber' value=$smarty.section.i.index}
    <div id="add-item-row-{$rowNumber}" class="honoree-row hiddenElement {cycle values="odd-row,even-row"}">
      <fieldset><legend>{ts}Gift Card {$rowNumber}{/ts}</legend>
      <div class="crm-section">
        <div class="label">
          {$form.honoree_name.$rowNumber.label}
        </div>
        <div class="content">
          {$form.honoree_name.$rowNumber.html}<br><sub>* Optional</sub>
        </div>
      </div>
      <br/>
      <div class="crm-section">
        <div class="label">
          {$form.gift_amount.$rowNumber.label}
        </div>
        <div class="content">
          {$form.gift_amount.$rowNumber.html}
        </div>
      </div>
      <div><a href=# class="remove_item crm-hover-button" style="float:right;"><b>{ts}Remove{/ts}</b></a></div>
      </fieldset>
    </div>
  {/section}
  <span id="add-another-item" class="crm-hover-button hiddenElement" style="font-weight:bold;padding:10px;"><a href=#>{ts}Add another card{/ts}</a></span>
</div>


{literal}
<script type="text/javascript">
CRM.$(function($) {
  $('#multiplehonorees').insertAfter($('#payment_information'));
  $('#total_card').on('keyup', function(e) {
    var count = parseInt($(this).val());
    var remaningcount = count + 1;
    if (isNaN(count)) {
      remaningcount = 1;
    }
    for (i = 1; i <= count; i++) {
      $('#add-item-row-' + i).removeClass('hiddenElement');
      $('#add-another-item').removeClass('hiddenElement');
    }
    for (i = remaningcount; i <= 25; i++) {
      $('#add-item-row-' + i).addClass('hiddenElement');
      var row = $('#add-item-row-' + i);
      $('input[name^="honoree_name"]', row).val('');
      $('input[id^="gift_amount"]', row).val('');
    }
  });
  $('#each_gift_amount').on('keyup', function(e) {
    var amount = parseFloat($(this).val());
    var count = parseInt($('#total_card').val());
    if (isNaN(amount)) {
      for (i = 1; i <= count; i++) {
        $('#gift_amount_' + i).val('');
      }
    }
    else {
      for (i = 1; i <= count; i++) {
        $('#gift_amount_' + i).val(amount);
      }
    }
  });
  $('.remove_item').on('click', function(e) {
    e.preventDefault();
    var row = $(this).closest('div.honoree-row');
    $('#add-another-item').show();
    $('input[name^="honoree_name"]', row).val('');
    $('input[id^="gift_amount"]', row).val('');
    row.addClass('hiddenElement').fadeOut("slow");
  });

  $('#add-another-item').on('click', function(e) {
    e.preventDefault();
    var hasHidden = $('div.honoree-row').hasClass("hiddenElement");
    if (hasHidden) {
      var row = $('#multiplehonorees div.hiddenElement:first');
      row.fadeIn("slow").removeClass('hiddenElement');
      hasHidden = $('div.honoree-row').hasClass("hiddenElement");
    }
    $('#add-another-item').toggle(hasHidden);
  });
});
</script>
{/literal}
