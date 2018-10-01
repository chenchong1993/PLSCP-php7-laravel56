define(["dojo/_base/declare","esri/dijit/PopupTemplate"],function(declare,PopupTemplate){
    return declare("Ips.PopupTemplate",PopupTemplate,{
        constructor: function(args){
            declare.safeMixin(this,args);
        }
    })
})