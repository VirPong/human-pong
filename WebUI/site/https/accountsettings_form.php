<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 *  AUTHORS:	Katie Mueller, Garrett Dieckmann, Aryn Grause
 *  DATE:	12/13/2011
 *
 *  accountsettings_form.php displays a form allowing the user to change his
 *  information in the database. With the exception of the password and PIN fields,
 *  the current user information stored in the database is displayed as the form
 *  defaults, serving the dual purpose of showing the user what information is
 *  currently stored and saving the user some keystrokes assuming they are not
 *  changing every single field.
 *
 *  accountsettings_form.php is only usable when logged in; if a user navigates to
 *  the page while logged out, he is redirected to the login form.
 *
 *  The form validation (checking for valid user input as a means of preventing SQL
 *  injection) requires the use of JavaScript. In the case of disabled Javascript
 *  the user is immediately redirected to skins/javascript.php, which asks that the
 *  user enable JavaScript to use this feature.
 *
 *  INCLUDES:	header.php
 *		footer.php
 *
 *  Javascript:	accountsettings.js
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
?>


<?php
	session_start();
	include_once('header.php');
?>


<script src="accountsettings.js" type="text/javascript"></script>
<noscript>
	<meta HTTP-EQUIV="REFRESH" content="0; url=skins/javascript.php">
</noscript>


<h1>&#9612; account settings &#9616;</h1>

<?php
	// if the user is logged in, retrieve their account information
	if (isset($_SESSION['username']))
	{
		// connect to the server and open db2
		$conn = mysql_connect('localhost', 'root', 'sawinrocks')
			or die (header('Location:skins/error.php'));
		mysql_select_db('db2', $conn)
			or die (header('Location:skins/error.php'));

		// pull out the relevant account information
		$myQuery = "SELECT username, firstname, lastname, email, birthday, 
			 gender FROM Customer WHERE username='"
			 . $_SESSION['username'] . "';";
		$customer = mysql_query($myQuery, $conn)
			or die (header('Location:skins/error.php'));
		$cust = mysql_fetch_row($customer);

		// save the appropriate account information for the form to access
		if($_SESSION['username']==$cust[0])
		{
			$firstname = $cust[1];
			$lastname = $cust[2];
			$email = $cust[3];
			$birthday = $cust[4];
			$gender = $cust[5];
			$year = $birthday[0] . $birthday[1]
			      . $birthday[2] . $birthday[3];
			$month = $birthday[5] . $birthday[6];
			$day = $birthday[8] . $birthday[9];
		}
	}

	// if the user is not logged in, send them to the login form
	else
	{
		header('Location:login_form.php');
	}

	// if the user entered an incorrect password, display an error message
	if(@$_GET['pw']=='false')
	{
		echo '<span class="errormsg">You must enter your current 
			password in order to update your account information.
			</span>';
	}

	mysql_close($conn);
?>

<p>
	<form name="accountsettings" class="inputarea" id="accountsettings" 
		method="post" action="accountsettings_post.php">
		<label for="username">Username</label>
		<input disabled type="text" size="20" name="username"
			value=<?php echo $_SESSION['username']; ?> /><br />
		<label for="password">Current password</label>
		<input type="password" size="20" name="password" /><br />
		<label for="newpassword">New password</label>
		<input type="password" size="20" name="newpassword" /><br />
		<label for="newpassword1">Confirm new password</label>
		<input type="password" size="20" name="newpassword1" /><br />
		<label for="pin">4-digit PIN</label>
		<input type="text" size="4" name="pin" /><br />
		<label for="firstname">First name</label>
		<input type="text" size="30" name="firstname" 
			value=<?php echo $firstname; ?> /><br />
		<label for="lastname">Last name</label>
		<input type="text" size="30" name="lastname" 
			value=<?php echo $lastname; ?> /><br />
		<label for="email">E-mail address</label>
		<input type="text" size="30" name="email" 
			value=<?php echo $email; ?> /><br />
		<label>Birthday</label>
		<select name="month">
			<option id="01" value="01">Jan</option>
			<option id="02" value="02">Feb</option>
			<option id="03" value="03">Mar</option>
			<option id="04" value="04">Apr</option>
			<option id="05" value="05">May</option>
			<option id="06" value="06">Jun</option>
			<option id="07" value="07">Jul</option>
			<option id="08" value="08">Aug</option>
			<option id="09" value="09">Sep</option>
			<option id="10" value="10">Oct</option>
			<option id="11" value="11">Nov</option>
			<option id="12" value="12">Dec</option>
			<script language="JavaScript">
				document.getElementById("<?php echo $month; ?>")
					.defaultSelected = true;
			</script>
		</select>
		<select name="day">
			<option id="01" value="01">1</option>
			<option id="02" value="02">2</option>
			<option id="03" value="03">3</option>
			<option id="04" value="04">4</option>
			<option id="05" value="05">5</option>
			<option id="06" value="06">6</option>
			<option id="07" value="07">7</option>
			<option id="08" value="08">8</option>
			<option id="09" value="09">9</option>
			<option id="10" value="10">10</option>
			<option id="11" value="11">11</option>
			<option id="12" value="12">12</option>
			<option id="13" value="13">13</option>
			<option id="14" value="14">14</option>
			<option id="15" value="15">15</option>
			<option id="16" value="16">16</option>
			<option id="17" value="17">17</option>
			<option id="18" value="18">18</option>
			<option id="19" value="19">19</option>
			<option id="20" value="20">20</option>
			<option id="21" value="21">21</option>
			<option id="22" value="22">22</option>
			<option id="23" value="23">23</option>
			<option id="24" value="24">24</option>
			<option id="25" value="25">25</option>
			<option id="26" value="26">26</option>
			<option id="27" value="27">27</option>
			<option id="28" value="28">28</option>
			<option id="29" value="29">29</option>
			<option id="30" value="30">30</option>
			<option id="31" value="31">31</option>
			<script language="JavaScript">
				document.getElementById("<?php echo $day; ?>")
					.defaultSelected = true;
			</script>
		</select>
		<select name="year">
			<option id="2011" value="2011">2011</option>
			<option id="2010" value="2010">2010</option>
			<option id="2009" value="2009">2009</option>
			<option id="2008" value="2008">2008</option>
			<option id="2007" value="2007">2007</option>
			<option id="2006" value="2006">2006</option>
			<option id="2005" value="2005">2005</option>
			<option id="2004" value="2004">2004</option>
			<option id="2003" value="2003">2003</option>
			<option id="2002" value="2002">2002</option>
			<option id="2001" value="2001">2001</option>
			<option id="2000" value="2000">2000</option>
			<option id="1999" value="1999">1999</option>
			<option id="1998" value="1998">1998</option>
			<option id="1997" value="1997">1997</option>
			<option id="1996" value="1996">1996</option>
			<option id="1995" value="1995">1995</option>
			<option id="1994" value="1994">1994</option>
			<option id="1993" value="1993">1993</option>
			<option id="1992" value="1992">1992</option>
			<option id="1991" value="1991">1991</option>
			<option id="1990" value="1990">1990</option>
			<option id="1989" value="1989">1989</option>
			<option id="1988" value="1988">1988</option>
			<option id="1987" value="1987">1987</option>
			<option id="1986" value="1986">1986</option>
			<option id="1985" value="1985">1985</option>
			<option id="1984" value="1984">1984</option>
			<option id="1983" value="1983">1983</option>
			<option id="1982" value="1982">1982</option>
			<option id="1981" value="1981">1981</option>
			<option id="1980" value="1980">1980</option>
			<option id="1979" value="1979">1979</option>
			<option id="1978" value="1978">1978</option>
			<option id="1977" value="1977">1977</option>
			<option id="1976" value="1976">1976</option>
			<option id="1975" value="1975">1975</option>
			<option id="1974" value="1974">1974</option>
			<option id="1973" value="1973">1973</option>
			<option id="1972" value="1972">1972</option>
			<option id="1971" value="1971">1971</option>
			<option id="1970" value="1970">1970</option>
			<option id="1969" value="1969">1969</option>
			<option id="1968" value="1968">1968</option>
			<option id="1967" value="1967">1967</option>
			<option id="1966" value="1966">1966</option>
			<option id="1965" value="1965">1965</option>
			<option id="1964" value="1964">1964</option>
			<option id="1963" value="1963">1963</option>
			<option id="1962" value="1962">1962</option>
			<option id="1961" value="1961">1961</option>
			<option id="1960" value="1960">1960</option>
			<option id="1959" value="1959">1959</option>
			<option id="1958" value="1958">1958</option>
			<option id="1957" value="1957">1957</option>
			<option id="1956" value="1956">1956</option>
			<option id="1955" value="1955">1955</option>
			<option id="1954" value="1954">1954</option>
			<option id="1953" value="1953">1953</option>
			<option id="1952" value="1952">1952</option>
			<option id="1951" value="1951">1951</option>
			<option id="1950" value="1950">1950</option>
			<option id="1949" value="1949">1949</option>
			<option id="1948" value="1948">1948</option>
			<option id="1947" value="1947">1947</option>
			<option id="1946" value="1946">1946</option>
			<option id="1945" value="1945">1945</option>
			<option id="1944" value="1944">1944</option>
			<option id="1943" value="1943">1943</option>
			<option id="1942" value="1942">1942</option>
			<option id="1941" value="1941">1941</option>
			<option id="1940" value="1940">1940</option>
			<option id="1939" value="1939">1939</option>
			<option id="1938" value="1938">1938</option>
			<option id="1937" value="1937">1937</option>
			<option id="1936" value="1936">1936</option>
			<option id="1935" value="1935">1935</option>
			<option id="1934" value="1934">1934</option>
			<option id="1933" value="1933">1933</option>
			<option id="1932" value="1932">1932</option>
			<option id="1931" value="1931">1931</option>
			<option id="1930" value="1930">1930</option>
			<option id="1929" value="1929">1929</option>
			<option id="1928" value="1928">1928</option>
			<option id="1927" value="1927">1927</option>
			<option id="1926" value="1926">1926</option>
			<option id="1925" value="1925">1925</option>
			<option id="1924" value="1924">1924</option>
			<option id="1923" value="1923">1923</option>
			<option id="1922" value="1922">1922</option>
			<option id="1921" value="1921">1921</option>
			<option id="1920" value="1920">1920</option>
			<option id="1919" value="1919">1919</option>
			<option id="1918" value="1918">1918</option>
			<option id="1917" value="1917">1917</option>
			<option id="1916" value="1916">1916</option>
			<option id="1915" value="1915">1915</option>
			<option id="1914" value="1914">1914</option>
			<option id="1913" value="1913">1913</option>
			<option id="1912" value="1912">1912</option>
			<option id="1911" value="1911">1911</option>
			<script language="JavaScript">
				document.getElementById("<?php echo $year; ?>")
					.defaultSelected = true;
			</script>
		</select><br />
		<label for="gender">Gender</label>
		<select name="gender">
			<option id="0" value="0">male</option>
			<option id="1" value="1">female</option>
			<script language="JavaScript">
				document.getElementById("<?php echo $gender; ?>")
					.defaultSelected = true;
			</script>
		</select><br />
		<label for="submitButton">&nbsp;</label>
		<input type="submit" value="Save changes" onclick="return validate();" />
	</form>
</p>


<?php
	include_once('footer.php');
?>