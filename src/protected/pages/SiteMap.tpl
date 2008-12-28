<com:TPanel CssClass="sitemap" Visible="true">

<!-- ADMINISTRATOR menu definition. Items: usuarios, proyectos, configuracion -->
<ul class="level1">
	<com:TPlaceHolder Visible=<%= $this->User->isInRole('admin1') %> >
	<li class="<com:TPlaceHolder ID="UserAdminMenu" />">
		<a class="menuitem" href="?page=User.UserList">
		<img src="<%= $this->Page->Theme->BaseUrl %>/group.gif" width="16" height="16" alt="">
		<span>Usuarios</span></a>
		<ul class="level2">
			<li><a href="?page=User.UserList">Listar</a></li>
			<li><a href="?page=User.UserCreate">Crear</a></li>
		</ul>
	</li>
	<li class="<com:TPlaceHolder ID="ProjAdminMenu" />">
		<a class="menuitem" href="?page=User.UserList">
		<img src="<%= $this->Page->Theme->BaseUrl %>/bell.gif" width="16" height="16" alt="">
		<span>Proyectos</span></a>
		<ul class="level2">
			<li><a href="?page=Project.ProjectList">Listar</a></li>
			<li><a href="?page=Project.ProjectDetails">Crear</a></li>
		</ul>
	</li>
	<li class="<com:TPlaceHolder ID="ConfMenu" />">
		<a class="menuitem" href="?page=User.UserList">
		<img src="<%= $this->Page->Theme->BaseUrl %>/time.gif" width="16" height="16" alt="">
		<span>Configuraci&oacute;n</span></a>
	</li>
	</com:TPlaceHolder>

<!-- PROJECT MANAGER menu definition. Items: proyecto, actividades, informes -->
<ul class="level1">
	<com:TPlaceHolder Visible=<%= $this->isManagerViewVisible() %> >
	<li class="<com:TPlaceHolder ID="ProjectMenu" />">
		<a class="menuitem" href="?page=Project.ProjectList">
		<img src="<%= $this->Page->Theme->BaseUrl %>/bell.gif" width="16" height="16" alt="">
		<span>Proyecto</span></a>
		<ul class="level2">
			<li><a href="?page=User.UserList">Fases</a></li>
			<li><a href="?page=User.UserCreate">Actividades</a></li>
			<li><a href="?page=User.UserList">Trabajadores</a></li>
		</ul>
	</li>
	<li class="<com:TPlaceHolder ID="ActManagementMenu" />">
		<a class="menuitem" href="?page=Project.LogTimeEntry">
		<img src="<%= $this->Page->Theme->BaseUrl %>/time.gif" width="16" height="16" alt="">
		<span>Actividades</span></a>
		<ul class="level2">
			<li><a href="?page=User.UserList">Supervisar</a></li>
			<li><a href="?page=User.UserCreate">Aprobar</a></li>
		</ul>
	</li>
	<li class="<com:TPlaceHolder ID="ReportManagerMenu" />">
		<a class="menuitem" href="?page=Report.ReportList">
		<img src="<%= $this->Page->Theme->BaseUrl %>/report.gif" width="16" height="16" alt="">
		<span>Informes</span></a>
	</li>
	</com:TPlaceHolder>

<!-- DEVELOPER menu definition. Items: actividades, informes, vacaciones -->
<ul class="level1">
	<com:TPlaceHolder Visible=<%= $this->isDeveloperViewVisible() %> >
	<li class="<com:TPlaceHolder ID="ActRegisterMenu" />">
		<a class="menuitem" href="?page=User.UserList">
		<img src="<%= $this->Page->Theme->BaseUrl %>/info.gif" width="16" height="16" alt="">
		<span>Actividades</span></a>
		<ul class="level2">
			<li><a href="?page=User.UserList">Nuevo registro</a></li>
			<li><a href="?page=User.UserCreate">Consultar estado</a></li>
		</ul>
	</li>
	<li class="<com:TPlaceHolder ID="ReportDeveloperMenu" />">
		<a class="menuitem" href="?page=User.UserList">
		<img src="<%= $this->Page->Theme->BaseUrl %>/report.gif" width="16" height="16" alt="">
		<span>Informe de actividades</span></a>
	</li>
	<li class="<com:TPlaceHolder ID="HolydaysMenu" />">
		<a class="menuitem" href="?page=User.UserList">
		<img src="<%= $this->Page->Theme->BaseUrl %>/time.gif" width="16" height="16" alt="">
		<span>Vacaciones</span></a>
		<ul class="level2">
			<li><a href="?page=User.UserList">A&nbsp;adir periodo vacacional</a></li>
		</ul>
	</li>
	</com:TPlaceHolder>

<!-- PERSONAL MANAGER menu definition. Items: informe de personal, informe de ocupación -->
<ul class="level1">
	<com:TPlaceHolder Visible=<%= $this->User->isInRole('personal') %> >
	<li class="<com:TPlaceHolder ID="ReportPersonalMenu" />">
		<a class="menuitem" href="?page=Report.ReportProject">
		<img src="<%= $this->Page->Theme->BaseUrl %>/report.gif" width="16" height="16" alt="">
		<span>Informe de personal</span></a>
	</li>
	<li class="<com:TPlaceHolder ID="ReportWorkerMenu" />">
		<a class="menuitem" href="?page=Report.ReportResource">
		<img src="<%= $this->Page->Theme->BaseUrl %>/report.gif" width="16" height="16" alt="">
		<span>Informe de ocupaci&oacute;n</span></a>
	</li>
	</com:TPlaceHolder>

<!-- Script to load controls dynamically -->
<com:TClientScript PradoScripts="prado">
	Event.OnLoad(function()
	{
		menuitems = $$(".menuitem");
		menuitems.each(function(el)
		{
			Event.observe(el, "mouseover", function(ev)
			{	
				menuitems.each(function(item)
				{
					Element.removeClassName(item.parentNode, "active");
				});
				node = Event.element(ev).parentNode;
				if(node.tagName.toLowerCase() != 'li')
					node = node.parentNode;
				Element.addClassName(node, "active");
			});
		});
	});
</com:TClientScript>
</com:TPanel>