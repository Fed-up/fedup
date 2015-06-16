<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <title>Nettuts Email Newsletter</title>
   <style type="text/css">
   	a {color: #4A72AF;}
	body, #header h1, #header h2, p {margin: 0; padding: 0;}
	#main {border: 1px solid #cfcece;}
	img {display: block;}
	#top-message p, #bottom-message p {color: #3f4042; font-size: 12px; font-family: Arial, Helvetica, sans-serif; }
	#header h1 {color: #ffffff !important; font-family: "Lucida Grande", "Lucida Sans", "Lucida Sans Unicode", sans-serif; font-size: 24px; margin-bottom: 0!important; padding-bottom: 0; }
	#header h2 {color: #ffffff !important; font-family: Arial, Helvetica, sans-serif; font-size: 24px; margin-bottom: 0 !important; padding-bottom: 0; }
	#header p {color: #ffffff !important; font-family: "Lucida Grande", "Lucida Sans", "Lucida Sans Unicode", sans-serif; font-size: 12px;  }
	h1, h2, h3, h4, h5, h6 {margin: 0 0 0.8em 0;}
	h3 {font-size: 28px; color: #444444 !important; font-family: Arial, Helvetica, sans-serif; }
	h4 {font-size: 22px; color: #4A72AF !important; font-family: Arial, Helvetica, sans-serif; }
	h5 {font-size: 18px; color: #444444 !important; font-family: Arial, Helvetica, sans-serif; }
	p {font-size: 12px; color: #444444 !important; font-family: "Lucida Grande", "Lucida Sans", "Lucida Sans Unicode", sans-serif; line-height: 1.5;}
   </style>
</head>



<body>



<table width="100%" cellpadding="0" cellspacing="0" bgcolor="e4e4e4"><tr><td>



	<table id="top-message" cellpadding="20" cellspacing="0" width="600" align="center">
		<tr>
			<td align="center">
				<p>Trouble viewing this email? <a href="#">View in Browser</a></p>
			</td>
		</tr>
	</table><!-- top message -->



	<table id="main" width="600" align="center" cellpadding="0" cellspacing="15" bgcolor="ffffff">
		<tr>
			<td>
				<table id="header" cellpadding="10" cellspacing="0" align="center" bgcolor="#91dd50">
					<tr>
						<td width="570" bgcolor="#91dd50"><h1>So Naughty But Nice</h1></td>
					</tr>
					<tr>
						<td width="570" bgcolor="#91dd50" ><h2 style="color:#ffffff!important">Let's Celebrate Event</h2></td>
					</tr>
				</table><!-- header --><!-- style="background: url(http://tessat.s3.amazonaws.com/email-bg.jpg);" -->
			</td>
		</tr><!-- header -->

		<tr>
			<td></td>
		</tr>
		<tr>
			<td>
				<table id="content-1" cellpadding="0" cellspacing="0" align="center">
					<tr>
						<td width="170" valign="top">
							<table cellpadding="5" cellspacing="0">
								<tr><td bgcolor="d0d0d0"><img src="http://tessat.s3.amazonaws.com/coins_small.jpg" width="170" /></td></tr></table>
						</td>
						<td width="15"></td>
						<td width="375" valign="top" colspan="3">
							<h4>{{$name}}: Email Confirmation</h4>
							<h5>Ticket ID: {{$ticket_id}}</h5>
							<h5>Quantity: {{$quantity}}</h5>
						</td>
					</tr>
				</table><!-- content 1 -->
			</td>
		</tr><!-- content 1 -->
		<tr>
			<td>
				<table id="content-2" cellpadding="0" cellspacing="0" align="center">
					<tr>
						<td width="570"><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p></td>
					</tr>
				</table><!-- content-2 -->
			</td>
		</tr><!-- content-2 -->
	</table><!-- main -->
	<table id="bottom-message" cellpadding="20" cellspacing="0" width="600" align="center">
		<tr>
			<td align="center">
				<p>You are receiving this email because you signed up for updates</p>
				<p><a href="sales@sonaughtybutnice.com">Enquires</a> | <a href="#">Forward to a friend</a> | <a href="http://www.sonaughtybutnice.com/event/{{$product_id}}">View in Browser</a></p>
			</td>
		</tr>
	</table><!-- top message -->
	</td></tr>
</table><!-- wrapper -->



</body>
</html>