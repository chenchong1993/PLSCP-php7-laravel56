define(["dojo/_base/declare","esri/toolbars/draw"],function(declare,draw){
    return declare("Ips.Draw",draw,{
        constructor: function(args){
            declare.safeMixin(this,args);
        }
    })
})