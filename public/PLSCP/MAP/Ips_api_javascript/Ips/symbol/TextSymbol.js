define(["dojo/_base/declare","esri/symbols/TextSymbol"],function(declare,TextSymbol){
    return declare("Ips.Map",TextSymbol,{
        constructor: function(args){
            declare.safeMixin(this,args);
        }
    })
})