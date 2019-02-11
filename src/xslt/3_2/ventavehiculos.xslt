<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:fn="http://www.w3.org/2005/xpath-functions" xmlns:ventavehiculos="http://www.sat.gob.mx/ventavehiculos">
	<xsl:output method="text" version="1.0" encoding="UTF-8" indent="no"/>
	<!-- Manejador de nodos tipo VentaVehiculos-->
	<xsl:template match="ventavehiculos:VentaVehiculos">
		<!--Iniciamos el tratamiento de los atributos del complemento concepto VentaVehiculos-->
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@version"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@ClaveVehicular"/>
		</xsl:call-template>

		<xsl:for-each select=".//ventavehiculos:InformacionAduanera">
			<xsl:apply-templates select="."/>
		</xsl:for-each>
	</xsl:template>

	<xsl:template match="ventavehiculos:InformacionAduanera">

		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@numero"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@fecha"/>
		</xsl:call-template>
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@aduana"/>
		</xsl:call-template>
	</xsl:template>
</xsl:stylesheet>