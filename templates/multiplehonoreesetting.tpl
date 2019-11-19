

<div id="multiple_honor_section_active-section">
  {$form.multiple_honor_section_active.html}{$form.multiple_honor_section_active.label}&nbsp;{help id="multiple-honoree_section"}
</div>

{literal}
<script type="text/javascript">
CRM.$(function($) {
  $('#multiple_honor_section_active-section').insertBefore($("#honor_block_is_active"));
});
</script>
{/literal}
