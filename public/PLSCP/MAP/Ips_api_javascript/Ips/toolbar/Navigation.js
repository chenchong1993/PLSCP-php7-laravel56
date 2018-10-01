define(["dojo/_base/declare","esri/toolbars/navigation"],function(declare,navigation){
    return declare("Ips.Navigation",navigation,{
        constructor: function(args){
            declare.safeMixin(this,args);
        }
    })
})