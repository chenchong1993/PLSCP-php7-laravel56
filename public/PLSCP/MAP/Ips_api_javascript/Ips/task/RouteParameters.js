define(["dojo/_base/declare","esri/tasks/RouteParameters"],function(declare,RouteParameters){
    return declare("Ips.RouteParameters",RouteParameters,{
        constructor: function(args){
            declare.safeMixin(this,args);
        }
    })
})