define(["dojo/_base/declare","esri/renderers/ClassBreaksRenderer"],function(declare,ClassBreaksRenderer){
    return declare("Ips.ClassBreaksRenderer",ClassBreaksRenderer,{
        constructor: function(args){
            declare.safeMixin(this,args);
        }
    })
})