<table class="table table-bordered">
    <thead>
        <tr>
            <th>Bulan</th>
            <th>Data Aktual</th>
            <th>Hasil Peramalan</th>
            <th>A - F</th>
            <th>MAD</th>
            <th>MSE</th>
            <th>MAPE</th>
        </tr>
    </thead>
    <tbody>
        <?php
        function format_angka($val) {
            if (!is_numeric($val)) return '-';
            return fmod($val, 1) == 0.0 ? number_format($val, 0) : rtrim(rtrim(number_format($val, 6, '.', ''), '0'), '.');
        }
		$sum_mad = 0;
		$sum_mse = 0;
		$sum_mape = 0;
        foreach ($hasil as $key => $has) :
            $aktual = $has['aktual'];
            $forecast = $has['hasil_peramalan'];

            if ($aktual !== null && $forecast !== null) {
                $selisih = $aktual - $forecast;
                $mad_row = abs($selisih);
                $mse_row = pow($selisih, 2);
                $mape_row = $aktual != 0 ? ($mad_row / $aktual) * 100 : 0;

				$sum_mad += $mad_row; 
				$sum_mse += $mse_row; 
				$sum_mape += $mape_row; 

            } else {
                $selisih = $mad_row = $mse_row = $mape_row = '-';
            }
        ?>
        <tr>
            <td><?= $has['bulan'] ?></td>
            <td><?= $aktual !== null ? format_angka($aktual) : '-' ?></td>
            <td><?= $forecast !== null ? format_angka($forecast) : '-' ?></td>
            <td><?= is_numeric($selisih) ? format_angka($selisih) : '-' ?></td>
            <td><?= is_numeric($mad_row) ? format_angka($mad_row) : '-' ?></td>
            <td><?= is_numeric($mse_row) ? format_angka($mse_row) : '-' ?></td>
            <td><?= is_numeric($mape_row) ? format_angka($mape_row) : '-' ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>

    <tfoot>
	 	<tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th><?= format_angka($sum_mad) ?></th>
            <th><?= format_angka($sum_mse) ?></th>
            <th><?= format_angka($sum_mape) ?></th>
        </tr>
		<tr>
			<th class="py-4"></th>
			<th class="py-4"></th>
			<th class="py-4"></th>
			<th class="py-4"></th>
			<th class="py-4"></th>
			<th class="py-4"></th>
			<th class="py-4"></th>
		</tr>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>MAD</th>
            <th>MSE</th>
            <th>MAPE</th>
        </tr>
        <tr>
             <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><?= format_angka($mad) ?></td>
            <td><?= format_angka($mse) ?></td>
            <td><?= format_angka($mape) ?></td>
        </tr>
    </tfoot>
</table>
