define(["dojo/_base/declare","esri/layers/FeatureLayer"],function(declare,FeatureLayer){
    return declare("Ips.FeatureLayer",FeatureLayer,{
        constructor: function(args){
            declare.safeMixin(this,args);
        }
    })
})