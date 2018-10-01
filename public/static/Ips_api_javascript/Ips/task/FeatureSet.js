define(["dojo/_base/declare","esri/tasks/FeatureSet"],function(declare,FeatureSet){
    return declare("Ips.FeatureSet",FeatureSet,{
        constructor: function(args){
            declare.safeMixin(this,args);
        }
    })
})