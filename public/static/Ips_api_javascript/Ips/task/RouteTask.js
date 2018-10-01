define(["dojo/_base/declare","esri/tasks/RouteTask"],function(declare,RouteTask){
    return declare("Ips.RouteTask",RouteTask,{
        constructor: function(args){
            declare.safeMixin(this,args);
        }
    })
})