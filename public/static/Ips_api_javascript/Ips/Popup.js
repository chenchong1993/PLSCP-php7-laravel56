define(["dojo/_base/declare","esri/dijit/Popup"],function(declare,Popup){
    return declare("Ips.Popup",Popup,{
        constructor: function(args){
            declare.safeMixin(this,args);
        }
    })
})