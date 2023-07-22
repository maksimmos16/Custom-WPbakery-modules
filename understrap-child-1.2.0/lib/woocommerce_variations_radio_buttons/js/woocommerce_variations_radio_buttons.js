(function($) {
    $(document).ready(function() {
        var table = $('table.variations');
		if(table.length==0) return;
		
		var i=0;
		var form = $('.product-type-variable .variations_form.cart');
		var product_variations = form.data('product_variations');
		var data = $('#variations_radio_buttons_data').data();
		//console.log(data);
		// console.log(product_variations);
		var html = '';
				
		//console.log('data=',data['region']);
		//html += '<div class="ws-variations-title">'+data['region']+'</div>';
		table.hide();
		table.find('tr').each(function(e){
			var tr = $(this);
			var select = tr.find('select');
			var id = select.attr('id');
			var cur = select.val();
			html += '<div class="ws-variations-title">'+tr.find('th label').html()+'</div>';
			select.find('option').each(function(){
				var opt = $(this);
				var v = opt.attr('value');
				var price_html = '';
				var stock_status_html = 'out of stock';
				var status_class = '';
				if(v!='') {
					var checked = (v==cur) ? ' checked ' : ' ';

					for(i=0;i<product_variations.length;i++){
						if(v==product_variations[i]['attributes']['attribute_'+id]) {
							price_html = '';
//							price_html += $.formatMoney(product_variations[i]['display_price'],2,',','.');
						//	price_html += ' ' + data['currency'];
							if(product_variations[i]['is_in_stock']) {
								status_class = 'instock';
								stock_status_html = '<span class="instock">'+data['instock']+'</span>';
							} else {
								status_class = 'outofstock';
								stock_status_html = '<span class="outofstock">'+data['outofstock']+'</span>';
							}
						}
					}

					html += '<label class="ws-radio '+status_class+'"><input class="ws_wc_variations_radio_buttons" type="radio" name="'+id+'" value="'+v+'" '+checked+'>';
					html += '<span>'+opt.text()+'<span class="var-add-info">';
                    html += price_html;
					html += ' ';
					html += stock_status_html;
					html += '</span></span></label>';
				}
			});
		});
		table.before(html);

		$(document).on('click','.ws_wc_variations_radio_buttons',function(e){
			var el = $(this);
			var id = el.attr('name');
			var val = el.attr('value');
			$('#'+id).val(val).change();
			$('.single_variation_wrap_outer').show();
		//	console.log(1234);
		});
    });
})(jQuery);



// <div class="small-title"><?php echo wc_attribute_label($attribute_keys[0]); ?></div>
