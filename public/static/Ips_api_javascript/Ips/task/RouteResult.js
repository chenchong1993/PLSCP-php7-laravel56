define(["dojo/_base/declare","esri/tasks/RouteResult"],function(declare,RouteResult){
    return declare("Ips.RouteResult",RouteResult,{
        constructor: function(args){
            declare.safeMixin(this,args);
        }
    })
})