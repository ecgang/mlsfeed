
<?php

$currentCurr = $this->getDataDetails('currency_code');
$price = $this->getDataDetails('price');
$priceFormat = mlsUtility::getInstance()->showNumberFormat($price);
$ref = $this->getDataDetails('ref');
 ?>
<ul class="item-price-wrap hide-on-list">
	<li class="item-price advmls-price-<?php echo $ref; ?>" data-fromcurr="<?php echo $currentCurr ?>" data-price="<?php echo $price; ?>"> <span><?php echo $currentCurr.' '.$priceFormat ?></span> 
	</li>
	<?php if (get_option('advmls_key_converter_curr', null)) { ?>
		<li>
			<select id="advmls-convert-price-<?php echo $ref; ?>" name="advmls_currency_converter" class="input-medium advmls_currency_converter" data-ref="<?php echo $ref; ?>" onChange="curr_converter(this)">
				<option value="" selected="selected">Currency</option>
				<option value="cad">CAD</option>
				<option value="eur">EUR</option>
				<option value="mxn">MXN</option>
				<option value="usd">USD</option>
			</select>
			<span class="btn-loader advmls-loader-js"></span>
		</li>
	<?php } ?>
</ul>