#!/bin/sh
# Instalador de SEPROSO.
# Usar un directorio público en un servidor Web (PHP 5.0.1 o posterior)

SEPROSO = seproso
PRADO = framework
SQLMAP = $(SEPROSO)/protected/data/mysql-sqlmap.xml

generateSQLMap()
{
rm $1/$(SQLMAP)
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>
<sqlMapConfig>
		
	<typeHandler type=\"SeprosoUser\" class=\"SeprosoUserTypeHandler\"/>
	<typeHandler type=\"DateTime\" class=\"DateTimeTypeHandler\" />

	<connection class=\"TDbConnection\"
		ConnectionString=\"mysql:host=localhost;dbname=$2\"
		Username=$3 Password=$4 />

	<sqlMap resource=\"MySQL/user.xml\"/>
	<sqlMap resource=\"MySQL/project.xml\"/>
	<sqlMap resource=\"MySQL/activity.xml\" />
	<sqlMap resource=\"MySQL/work-record.xml\" />
	<sqlMap resource=\"MySQL/worker.xml\" />
	<sqlMap resource=\"MySQL/reports.xml\" />
    
</sqlMapConfig>" > $1/$(SQLMAP)
}

# Comprobamos el número de parametros
if test $# -lt 1
then
	echo "Error. Use: $0 dir database user password"

# Comprobamos que se trata de un directorio valido
if test -d $1
then
	echo "INICIO DE LA INSTALACIÓN"
	cp -R $(SEPROSO) $1
	cp -R $(PRADO) $1
	chmod a+w $1/$(SEPROSO)/assets
	chmod a+w $1/$(SEPROSO)/protected/runtime
	generateSQLMap()
else
	echo "$1 no es un directorio valido."
fi
