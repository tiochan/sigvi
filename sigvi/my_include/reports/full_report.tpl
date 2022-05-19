<table class="report">
	<th class="report" colspan="2">
		<h1>Security status report</h1>
	</th>

	<tr class='report' valign="top">
		<td class="report">
			<p class="report_title">
				Recuento de vulnerabilidades
			</p>
			<p class="report">
				En el &uacute;ltimo mes han aparecido {VULN_LAST_MONTH} nuevas vulnerabilidades,
				lo que supone un <tt class="report_data">{VULN_INCR_DECR_STR} de {INCR_DECR_DEC}</tt> vulnerabilidades
				respecto al mes anterior.
			</p>
			<p class="report">
				El n&uacute;mero total de vulnerabilidades que se han descargado hasta la fecha
				es de {VULN_TOTAL}
			</p>
			<p class="report_title">
				Recuento de alertas
			</p>
			<p class="report">
				En cuanto al n&uacute;mero de alertas creadas, el pasado mes aparecieron
				{ALERT_LAST_MONTH}, la mayor&iacute;a
			</p>
			<p class="report">
			Numero de vulnerabilidades del ultimo mes: {VULN_LAST_MONTH}<br>
			Numero de alertas del ultimo mes: {ALERT_LAST_MONTH}<br>
			Numero total de alertas creadas: {ALERT_TOTAL}<br>
			De las cuales:
			Numero total de alertas descartadas: {ALERT_TOTAL_DISCARDED}<br>
			Numero de alertas abiertas (o pendientes): {ALERT_OPENED}<br>
			</p>
		</td>
		<td class="report">
			<img src="vulnerability_vs_alert.graph.php"/>
		</td>
	</tr>
	<tr class='report' valign="top">
		<td class="report">
			Numero de vulnerabilidades del ultimo mes: {VULN_LAST_MONTH}<br>
			Numero de alertas del ultimo mes: {ALERT_LAST_MONTH}<br>
			Numero total de alertas creadas: {ALERT_TOTAL}<br>
			De las cuales:
			Numero total de alertas descartadas: {ALERT_TOTAL_DISCARDED}<br>
			Numero de alertas abiertas (o pendientes): {ALERT_OPENED}<br>
		</td>
		<td class="report">
			<img src="alert_status.graph.php"/>
		</td>
	</tr>
	<tr class='report' valign="top">
		<td class="report">
			Numero de vulnerabilidades del ultimo mes: {VULN_LAST_MONTH}<br>
			Numero de alertas del ultimo mes: {ALERT_LAST_MONTH}<br>
			Numero total de alertas creadas: {ALERT_TOTAL}<br>
			De las cuales:
			Numero total de alertas descartadas: {ALERT_TOTAL_DISCARDED}<br>
			Numero de alertas abiertas (o pendientes): {ALERT_OPENED}<br>
		</td>
		<td class="report">
			<img src="alert_type.graph.php"/>
		</td>
	</tr>

</table>
