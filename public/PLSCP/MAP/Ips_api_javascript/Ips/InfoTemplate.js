define(["dojo/_base/declare","esri/InfoTemplate"],function(declare,InfoTemplate){
    return declare("Ips.InfoTemplate",InfoTemplate,{
        constructor: function(args){
            declare.safeMixin(this,args);
        }
    })
})