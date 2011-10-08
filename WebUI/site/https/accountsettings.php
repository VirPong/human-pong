<?php
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">


	<head>
		<link href="css/classic.css" rel="stylesheet" type="text/css" />
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />

		<title>virPONG</title>

	</head>


	<body>

		<?php
			if (isset($_SESSION['username']))
			{

				$conn = mysql_connect('localhost', 'root', 'sawinrocks')
					or die ("Could not connect to server." . mysql_error());

				mysql_select_db('db2', $conn)
					or die ("Could not open database 2." . mysql_error());

				$myQuery = "SELECT firstname, lastname, email, birthday, gender FROM Customer WHERE username=" . $_SESSION['username'];
				$account = mysql_query($myQuery, $conn)
					or die ("Could not retriever customer information." . mysql_error());

				echo 'Username <b>' . $_SESSION['username'] . '</b><br />';
				echo '<form name="accountsettings" id="accountsettings" method="post" action="accountsettings_post.php">';
				echo 'Current password <input type="password" size="20" name="password"/><br />';
				echo 'New password <input type="password" size="20" name="newpassword" /><br />';
				echo 'Confirm new password <input type="password" size="20" name="newpassword1" /><br />';
				echo 'First name <input type="text" size="20" name="firstname" /><br />';
				echo 'Last name <input type="text" size="50" name="lastname" /><br />';
				echo 'E-mail address <input type="text" size="50" name="email" /><br />';
				echo 'Birthday <select name="month">';
					echo '<option value="01">Jan</option>';
					echo '<option value="02">Feb</option>';
					echo '<option value="03">Mar</option>';
					echo '<option value="04">Apr</option>';
					echo '<option value="05">May</option>';
					echo '<option value="06">Jun</option>';
					echo '<option value="07">Jul</option>';
					echo '<option value="08">Aug</option>';
					echo '<option value="09">Sep</option>';
					echo '<option value="10">Oct</option>';
					echo '<option value="11">Nov</option>';
					echo '<option value="12">Dec</option>';
				echo '</select>';
				echo '<select name="day">';
					echo '<option value="01">1</option>';
					echo '<option value="02">2</option>';
					echo '<option value="03">3</option>';
					echo '<option value="04">4</option>';
					echo '<option value="05">5</option>';
					echo '<option value="06">6</option>';
					echo '<option value="07">7</option>';
					echo '<option value="08">8</option>';
					echo '<option value="09">9</option>';
					echo '<option value="10">10</option>';
					echo '<option value="11">11</option>';
					echo '<option value="12">12</option>';
					echo '<option value="13">13</option>';
					echo '<option value="14">14</option>';
					echo '<option value="15">15</option>';
					echo '<option value="16">16</option>';
					echo '<option value="17">17</option>';
					echo '<option value="18">18</option>';
					echo '<option value="19">19</option>';
					echo '<option value="20">20</option>';
					echo '<option value="21">21</option>';
					echo '<option value="22">22</option>';
					echo '<option value="23">23</option>';
					echo '<option value="24">24</option>';
					echo '<option value="25">25</option>';
					echo '<option value="26">26</option>';
					echo '<option value="27">27</option>';
					echo '<option value="28">28</option>';
					echo '<option value="29">29</option>';
					echo '<option value="30">30</option>';
					echo '<option value="31">31</option>';
				echo '</select>';
				echo '<select name="year">';
					echo '<option value="2011">2011</option>';
					echo '<option value="2010">2010</option>';
					echo '<option value="2009">2009</option>';
					echo '<option value="2008">2008</option>';
					echo '<option value="2007">2007</option>';
					echo '<option value="2006">2006</option>';
					echo '<option value="2005">2005</option>';
					echo '<option value="2004">2004</option>';
					echo '<option value="2003">2003</option>';
					echo '<option value="2002">2002</option>';
					echo '<option value="2001">2001</option>';
					echo '<option value="2000">2000</option>';
					echo '<option value="1999">1999</option>';
					echo '<option value="1998">1998</option>';
					echo '<option value="1997">1997</option>';
					echo '<option value="1996">1996</option>';
					echo '<option value="1995">1995</option>';
					echo '<option value="1994">1994</option>';
					echo '<option value="1993">1993</option>';
					echo '<option value="1992">1992</option>';
					echo '<option value="1991">1991</option>';
					echo '<option value="1990">1990</option>';
					echo '<option value="1989">1989</option>';
					echo '<option value="1988">1988</option>';
					echo '<option value="1987">1987</option>';
					echo '<option value="1986">1986</option>';
					echo '<option value="1985">1985</option>';
					echo '<option value="1984">1984</option>';
					echo '<option value="1983">1983</option>';
					echo '<option value="1982">1982</option>';
					echo '<option value="1981">1981</option>';
					echo '<option value="1980">1980</option>';
					echo '<option value="1979">1979</option>';
					echo '<option value="1978">1978</option>';
					echo '<option value="1977">1977</option>';
					echo '<option value="1976">1976</option>';
					echo '<option value="1975">1975</option>';
					echo '<option value="1974">1974</option>';
					echo '<option value="1973">1973</option>';
					echo '<option value="1972">1972</option>';
					echo '<option value="1971">1971</option>';
					echo '<option value="1970">1970</option>';
					echo '<option value="1969">1969</option>';
					echo '<option value="1968">1968</option>';
					echo '<option value="1967">1967</option>';
					echo '<option value="1966">1966</option>';
					echo '<option value="1965">1965</option>';
					echo '<option value="1964">1964</option>';
					echo '<option value="1963">1963</option>';
					echo '<option value="1962">1962</option>';
					echo '<option value="1961">1961</option>';
					echo '<option value="1960">1960</option>';
					echo '<option value="1959">1959</option>';
					echo '<option value="1958">1958</option>';
					echo '<option value="1957">1957</option>';
					echo '<option value="1956">1956</option>';
					echo '<option value="1955">1955</option>';
					echo '<option value="1954">1954</option>';
					echo '<option value="1953">1953</option>';
					echo '<option value="1952">1952</option>';
					echo '<option value="1951">1951</option>';
					echo '<option value="1950">1950</option>';
					echo '<option value="1949">1949</option>';
					echo '<option value="1948">1948</option>';
					echo '<option value="1947">1947</option>';
					echo '<option value="1946">1946</option>';
					echo '<option value="1945">1945</option>';
					echo '<option value="1944">1944</option>';
					echo '<option value="1943">1943</option>';
					echo '<option value="1942">1942</option>';
					echo '<option value="1941">1941</option>';
					echo '<option value="1940">1940</option>';
					echo '<option value="1939">1939</option>';
					echo '<option value="1938">1938</option>';
					echo '<option value="1937">1937</option>';
					echo '<option value="1936">1936</option>';
					echo '<option value="1935">1935</option>';
					echo '<option value="1934">1934</option>';
					echo '<option value="1933">1933</option>';
					echo '<option value="1932">1932</option>';
					echo '<option value="1931">1931</option>';
					echo '<option value="1930">1930</option>';
					echo '<option value="1929">1929</option>';
					echo '<option value="1928">1928</option>';
					echo '<option value="1927">1927</option>';
					echo '<option value="1926">1926</option>';
					echo '<option value="1925">1925</option>';
					echo '<option value="1924">1924</option>';
					echo '<option value="1923">1923</option>';
					echo '<option value="1922">1922</option>';
					echo '<option value="1921">1921</option>';
					echo '<option value="1920">1920</option>';
					echo '<option value="1919">1919</option>';
					echo '<option value="1918">1918</option>';
					echo '<option value="1917">1917</option>';
					echo '<option value="1916">1916</option>';
					echo '<option value="1915">1915</option>';
					echo '<option value="1914">1914</option>';
					echo '<option value="1913">1913</option>';
					echo '<option value="1912">1912</option>';
					echo '<option value="1911">1911</option>';
				echo '</select><br />';
				echo 'Gender <select name="gender">';
					echo '<option value="0">male</option>';
					echo '<option value="1">female</option>';
				echo '</select><br />';
				echo '<input type="submit" name="submitButton" value="Save changes" />';
				echo '</form>';
			}
			else
			{
				echo 'You are not logged in. Please <a href=login_form.php>log in</a> to access your account settings.';
			}
		?>

	</body>


</html>