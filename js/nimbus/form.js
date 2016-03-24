jQuery(function(){
	jQuery.get(api_url + 'manufacturers', function(data){ load_mfrs(data); });
});

function load_mfrs(data)
{
	mfr_select = jQuery('#mfr-input');
	loaded_saved_mfr = false;

	jQuery.each(data.data, function(i, mfr) {
		var selected = (mfr.id == saved_mfr) ? ' selected' : '';

		if (selected !== '')
			loaded_saved_mfr = true;

		var mfr_option = jQuery('<option value="' + mfr.id + '"' + selected + '>' + mfr.name + '</option>');
		mfr_select.append(mfr_option);
	});

	mfr_select.selectize({
		onChange: function(value) {
			jQuery.get(api_url + 'manufacturers/' + value + '/products', function(data){ load_prods(data); });
		}
	});

	if (loaded_saved_mfr)
		jQuery.get(api_url + 'manufacturers/' + saved_mfr + '/products', function(data){ load_prods(data); });
}

function load_prods(data)
{
	prod_select = jQuery('#prod-input');
	prod_select.empty();

	jQuery.each(data.data, function(i, prod) {
		var selected = (prod.id == saved_prod) ? ' selected' : '';
		var prod_option = jQuery('<option value="' + prod.id + '"'+ selected +'>' + prod.name + ' (' + prod.sku + ')</option>');
		prod_select.append(prod_option);
	});

	prod_select.prop('disabled', false);
}