define(["dojo/_base/declare","esri/renderers/HeatmapRenderer"],function(declare,HeatmapRenderer){
    return declare("Ips.HeatmapRenderer",HeatmapRenderer,{
        constructor: function(args){
            declare.safeMixin(this,args);
        }
    })
})