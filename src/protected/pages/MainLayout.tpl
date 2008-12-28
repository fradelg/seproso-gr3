<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<com:THead Title="SEPROSO - Grupo 3 - ISO 2" />
<body>

<com:TForm>

<h1 class="heading">
	<a href="index.php">SEPROSO 
		<span class="subheading">Grupo 3</span>
	</a>
</h1>

<div class="minheading">
<h2 class="login">
	<com:TLabel CssClass="name" Text="Bienvenido <%= h($this->User->Name) %>" />
	<font size="1">
	<com:THyperLink 
		Text="(Entrar)"
		NavigateUrl=<%= $this->Service->constructUrl('User.Login') %>
		Visible=<%= $this->User->getIsGuest() %> />
	<com:THyperLink 
		Text="(Salir)"
		NavigateUrl=<%= $this->Service->constructUrl('User.Logout') %>
		Visible=<%= !$this->User->getIsGuest() %> />
	</font>
</h2>
<h2 class="login">
	<com:TLabel CssClass="name" Text="Proyecto:" Visible=<%= !$this->User->getIsGuest() %> />
	<com:TDropDownList ID="projects" 
		CssClass="sheetfor" 
		AutoPostBack="True"
		SelectedValue=<%= $this->getProjectDao()->getProjectID($this->getProject()) %>
		OnSelectedIndexChanged="projectChanged"
		Visible=<%= !$this->User->getIsGuest() %> />
</h2>
<h2 class="help"><a href="?page=Welcome">Ayuda</a></h2>
</div>

<com:Application.pages.SiteMap Visible=<%= !$this->User->getIsGuest() %> />

<div class="main">
<com:TContentPlaceHolder ID="Main" />
</div>

</com:TForm>

<div class="copyrights">
Copyright &copy; 2008-2009 <a href="?page=Contact">Grupo 3</a>.
Powered by <a href="http://www.pradosoft.com/">PRADO</a>.
</div>

</body>
</html>