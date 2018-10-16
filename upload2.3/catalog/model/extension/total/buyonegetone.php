<?php

class ModelExtensionTotalBuyonegetone extends Model {
	public function getTotal($total) {
		$this->load->language('extension/total/buyonegetone');

		$jumlahBarang = $this->cart->countProducts();

		$jumlahGratis = floor($jumlahBarang/2);
		$keranjang = $this->cart->getProducts();

		$buyonegetone = 0;
		$hitung = 1;
		foreach ($keranjang as $key => $k) {
			$qty = $k['quantity'];

			for ($i=0; $i < $qty; $i++) { 
				if ($hitung <= $jumlahGratis) {
					$buyonegetone +=$k['price'];
					$hitung++;
				}
			}
		}

		// $this->array_sort_by_column($keranjang, 'price');

		$total['totals'][] = array(
			'code'       => 'buyonegetone',
			'title'      => $this->language->get('text_buyonegetone'),
			'value'      => $buyonegetone,
			'sort_order' => $this->config->get('buyonegetone_sort_order')
		);

		$total['total'] -= $buyonegetone;
	}

	public function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
		$sort_col = array();
		foreach ($arr as $key=> $row) {
			$sort_col[$key] = $row[$col];
		}

		array_multisort($sort_col, $dir, $arr);
	}
}