define(["dojo/_base/declare","esri/map"],function(declare,Map){
    return declare("Ips.Map",Map,{
        constructor: function(args){
            declare.safeMixin(this,args);
        }
    })
})