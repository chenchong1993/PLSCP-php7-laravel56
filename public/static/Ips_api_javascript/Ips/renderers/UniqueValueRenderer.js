define(["dojo/_base/declare","esri/renderers/UniqueValueRenderer"],function(declare,UniqueValueRenderer){
    return declare("Ips.UniqueValueRenderer",UniqueValueRenderer,{
        constructor: function(args){
            declare.safeMixin(this,args);
        }
    })
})