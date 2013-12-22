<?php
/**
*@package pXP
*@file    SubirArchivo.php
*@author  Freddy Rojas 
*@date    22-03-2012
*@description permites subir archivos a la tabla de documento_sol
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.SubirArchivo=Ext.extend(Phx.frmInterfaz,{

    constructor:function(config)
    {   
        Phx.vista.SubirArchivo.superclass.constructor.call(this,config);
        this.init();    
        this.loadValoresIniciales();
    },
    
    loadValoresIniciales:function()
    {        
        Phx.vista.SubirArchivo.superclass.loadValoresIniciales.call(this);
        this.getComponente('id_plantilla_entidad').setValue(this.id_plantilla_entidad);            
    },
    
    successSave:function(resp)
    {
        Phx.CP.loadingHide();
        Phx.CP.getPagina(this.idContenedorPadre).reload();
        this.panel.close();
    },
                
    
    Atributos:[
        {
            config:{
                labelSeparator:'',
                inputType:'hidden',
                name: 'id_plantilla_entidad'
            },
            type:'Field',
            form:true
        },
         
        
        {
            config:{
                fieldLabel: "Icono",
                gwidth: 130,
                inputType:'file',
                name: 'archivo',
                buttonText: '', 
                maxLength:150,
                anchor:'100%'                   
            },
            type:'Field',
            form:true 
        },      
    ],
    title:'Subir Archivo',    
    fileUpload:true,
    
    guardar: function(o){
        // arma json en cadena para enviar al servidor
        Ext.apply(this.argumentSave, o.argument);
        if (this.fileUpload) {
            Ext.Ajax.request({
                form: this.form.getForm().getEl(),
                url: this.ActSave,
                params: this.getValForm,
                isUpload: this.fileUpload,
                success: this.successSaveFileUpload,
                argument: this.argumentSave,
                failure: function(r)
                {
                    console.log('falla upload', r)
                },
                timeout: this.timeout,
                scope: this
            });
        } else {
            Ext.Ajax.request({
            url: this.ActSave,
            params: this.getValForm,
            isUpload: this.fileUpload,
            success: this.successSave,
            argument: this.argumentSave,
            failure: this.conexionFailure,
            timeout: this.timeout,
            scope: this
            });
        }          
    },    
    
    onSubmit: function(o) {
        if (this.form.getForm().isValid()) {
            //Phx.CP.loadingShow();            
            
            this.ActSave='../../sis_netman/control/PlantillaEntidad/subirArchivo';
            this.guardar(o);
            
        }
    } 
}
)    
</script>