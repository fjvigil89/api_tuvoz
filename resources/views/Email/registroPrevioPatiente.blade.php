<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<meta name="theme-color" content="#000000" />
	<!--
      manifest.json provides metadata used when your web app is added to the
      homescreen on Android. See https://developers.google.com/web/fundamentals/engage-and-retain/web-app-manifest/
    -->
	<link rel="manifest" href="%PUBLIC_URL%/manifest.json" />
	<link rel="shortcut icon" href="%PUBLIC_URL%/favicon.ico" />
	<link rel="apple-touch-icon" sizes="76x76" href="%PUBLIC_URL%/apple-icon.png" />
	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
	<title>API TuVoz</title>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC9FgL9L88CUttcm0GH5lpTrSge3Sgz03A"></script>

</head>

<body>
	<div>
	</div>
	<h2></h2>


	<div data-marker="__QUOTED_TEXT__">
		<div style="font-family: arial, helvetica, sans-serif; font-size: 12pt; color: #000000;">
			<div>
				<div style="font-family: arial, helvetica, sans-serif; font-size: 12pt; color: #000000;">
					<div>
						<div style="font-family: arial, helvetica, sans-serif; font-size: 12pt; color: #000000;"><br />
							<div>
								<div style="font-family: arial, helvetica, sans-serif; font-size: 12pt; color: #000000;"><br />
									<div>
										<div style="font-family: arial, helvetica, sans-serif; font-size: 12pt; color: #000000;"><br />
											<div>
												<div style="font-family: arial, helvetica, sans-serif; font-size: 12pt; color: #000000;">
													<div>
														<div style="font-family: arial, helvetica, sans-serif; font-size: 12pt; color: #000000;">
															<div>
																<div style="font-family: arial, helvetica, sans-serif; font-size: 12pt; color: #000000;">
																	<div>
																		<div class="WordSection1">
																			<div align="center">
																				<table class="MsoNormalTable" style="width: 100.0%; background: #F2F1ED; border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="0" border="0">
																					<tbody>
																						<tr>
																							<td style="padding: 0cm 0cm 0cm 0cm;">
																								<div align="center">
																									<table class="MsoNormalTable" style="background: #F2F1ED; border-collapse: collapse;" width="921" cellspacing="0" cellpadding="0" border="0">
																										<tbody>
																											<tr>
																												<td style="padding: 0cm 61.2pt 0cm 61.2pt; text-rendering: optimizelegibility;">
																													<p style="margin-bottom: 15.0pt; text-align: center; mso-line-height-alt: 40.0pt;" align="center">
																														<span style="font-size: 40.5pt; font-family: 'Helvetica',sans-serif; color: #50b96c;">
																															<img src="{{ $message->embed(public_path() . '/images/tuvoz-logo-color.png') }}" alt="TuVozLogo" width="100" height="50" />

																															<span style="font-size: 36pt; line-height: 107%; font-family: 'Calibri', 'sans-serif';">
																																Plataforma de TuVoz
																															</span>.<br />
																														</span>
																													</p>
																												</td>
																											</tr>
																											<tr>
																												<td style="padding: 0cm 61.2pt 0cm 61.2pt; text-rendering: optimizelegibility;"></td>
																											</tr>
																											<tr>
																												<td style="padding: 0cm 61.2pt 0cm 61.2pt; text-rendering: optimizelegibility;"></td>
																											</tr>
																											<tr>
																												<td style="background: white; padding: 37.5pt 61.2pt 0cm 61.2pt; text-rendering: optimizelegibility;">
																													<div style="text-align: center;">
																														<p style="margin: 0px;"><span style="font-family: georgia, serif; font-size: 12pt;">
																																¡Bienvenido a TuVoz!

																															</span><br />
																														</p>


																													</div>
																													<div style="text-align: justify;">
																														<p style="margin: 0px;"><span style="font-family: georgia, serif; font-size: 12pt;">
																																TuVoz es la plataforma para el diagnóstico del trastorno del habla. Contamos con un equipo multidisciplinario de profesionales que podrán ayudarlo a mejorar.
																															</span><br />
																														</p>
																													</div>
																													<div style="text-align: justify;">
																														<p style="margin: 0px;"><span style="font-family: georgia, serif; font-size: 12pt;">
																																La Plataforma TuVoz y sus especialistas quieren que te registres, por favor, haz clic o copia en tu navegador el siguiente enlace para establecer una contraseña y activar tu usuario:
																																<a href="{{ route('api.pre_register', ['url' => $url_register , 'identificador' => $identificador, 'email' => $email, 'role'=>$role	 ]) }}">
																																	{!! $url_register !!}&ident={!! $identificador !!}
																																</a>
																																en la Plataforma.
																															</span><br />
																														</p>


																														<p style="margin: 0px;"><span style="font-family: georgia, serif; font-size: 12pt;">&nbsp;</span></p>
																													</div>

																												</td>
																											</tr>
																											<tr>
																												<td style="background: white; padding: 37.5pt 61.2pt 0cm 61.2pt; text-rendering: optimizelegibility;"></td>
																											</tr>
																											<tr>
																												<td style="padding: 0cm 0cm 0cm 0cm;">
																													<div align="center">
																														<table class="MsoNormalTable" cellspacing="0" cellpadding="0" border="0">
																															<tbody>
																																<tr>
																																	<td style="padding: 30.0pt 0cm 22.5pt 0cm;">
																																		<div align="center">
																																			<table class="MsoNormalTable" style="width: 30.0pt; border-collapse: collapse;" width="40" cellspacing="0" cellpadding="0" border="0">
																																				<tbody>
																																					<tr>
																																						<td style="padding: 0cm 0cm 0cm 0cm;">
																																							<p class="MsoNormal" style="text-align: center;" align="center">
																																								<img id="_x0000_i1026" alt="TuVoz Logo" width="40" height="42" src="{{ $message->embed(public_path() . '/images/tuvoz-logo-color.png') }}" />
																																							</p>
																																						</td>
																																					</tr>
																																				</tbody>
																																			</table>
																																		</div>
																																	</td>
																																	<td style="padding: 30.0pt 0cm 22.5pt 0cm;">
																																		<p class="MsoNormal" style="line-height: 0%;"><span style="font-size: 1.0pt;">&nbsp;</span></p>
																																	</td>
																																	<td style="padding: 0cm 0cm 0cm 7.5pt;">
																																		<p class="MsoNormal" style="text-align: center;">
																																			<span style="font-size: 8.5pt; font-family: 'Helvetica',sans-serif; color: #bdbbb3;">
																																				© TuVoz <br />
																																				Trabajamos para Usted. <br />
																																				2021 | <a href="#"> Aviso legal </a>| <a href="#"> Contactar </a>
																																			</span>
																																		</p>


																																	</td>
																																</tr>
																															</tbody>
																														</table>
																													</div>
																												</td>
																											</tr>
																										</tbody>
																									</table>
																								</div>
																							</td>
																						</tr>
																					</tbody>
																				</table>
																			</div>
																			<p class="MsoNormal"><span style="font-family: 'Arial',sans-serif; color: black;">&nbsp;</span></p>
																			<p class="MsoNormal"><span style="font-family: 'Arial',sans-serif; color: black;">&nbsp;</span></p>
																			<p class="MsoNormal"><span style="font-family: 'Arial',sans-serif; color: black;">&nbsp;</span></p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


</body>

</html>