/*!
 * ZUI: 数据表格 - v1.8.1 - 2018-11-14
 * http://zui.sexy
 * GitHub: https://github.com/easysoft/zui.git 
 * Copyright (c) 2018 cnezsoft.com; Licensed MIT*/
!function(a){"use strict";var t="zui.datatable",e=a.zui.store,s=function(e,s){this.name=t,this.$=a(e),this.isTable="TABLE"===this.$[0].tagName,this.firstShow=!0,this.isTable?(this.$table=this.$,this.id="datatable-"+(this.$.attr("id")||a.zui.uuid())):(this.$datatable=this.$.addClass("datatable"),this.$.attr("id")?this.id=this.$.attr("id"):(this.id="datatable-"+a.zui.uuid(),this.$.attr("id",this.id))),this.getOptions(s),this.load(),this.callEvent("ready")};s.DEFAULTS={checkable:!1,checkByClickRow:!0,checkedClass:"active",checkboxName:null,selectable:!0,sortable:!1,storage:!0,fixedHeader:!1,fixedHeaderOffset:0,fixedLeftWidth:"30%",fixedRightWidth:"30%",flexHeadDrag:!0,scrollPos:"in",rowHover:!0,colHover:!0,hoverClass:"hover",colHoverClass:"col-hover",fixCellHeight:!0,mergeRows:!1,minColWidth:20,minFixedLeftWidth:200,minFixedRightWidth:200,minFlexAreaWidth:200},s.prototype.getOptions=function(t){var e=this.$;t=a.extend({},s.DEFAULTS,this.$.data(),t),t.tableClass=t.tableClass||"",t.tableClass=" "+t.tableClass+" table-datatable",a.each(["bordered","condensed","striped","condensed","fixed"],function(a,s){s="table-"+s,e.hasClass(s)&&(t.tableClass+=" "+s)}),(e.hasClass("table-hover")||t.rowHover)&&(t.tableClass+=" table-hover"),t.checkable&&a.fn.selectable||(t.selectable=!1),this.options=t},s.prototype.load=function(e){var s,l=this.options;if(a.isFunction(e))e=e(this.data,this),e.keepSort=!0;else if(a.isPlainObject(e))this.data=e;else if("string"==typeof e){var d=a(e);d.length&&(this.$table=d.first(),this.$table.data(t,this),this.isTable=!0),e=null}else e=l.data;if(!e){if(!this.isTable)throw new Error("No data avaliable!");e={cols:[],rows:[]},s=e.cols;var i,r,o,n,c,h,f=e.rows,p=this.$table;p.children("thead").children("tr:first").children("th").each(function(){r=a(this),s.push(a.extend({text:r.html(),flex:r.hasClass("flex-col"),width:"auto",cssClass:r.attr("class"),css:r.attr("style"),type:"string",ignore:r.hasClass("ignore"),sort:!r.hasClass("sort-disabled"),mergeRows:r.attr("merge-rows"),title:r.attr("title")},r.data()))}),p.children("tbody").children("tr").each(function(){o=a(this),c=a.extend({data:[],checked:!1,cssClass:o.attr("class"),css:o.attr("style"),id:o.attr("id")},o.data()),o.children("td").each(function(){if(n=a(this),h=n.attr("colspan")||1,c.data.push(a.extend({cssClass:n.attr("class"),css:n.attr("style"),text:n.html(),colSpan:h,title:n.attr("title")},n.data())),h>1)for(i=1;i<h;i++)c.data.push({empty:!0})}),f.push(c)});var b=p.children("tfoot");b.length&&(e.footer=a('<table class="table'+l.tableClass+'"></table>').append(b))}e.flexStart=-1,e.flexEnd=-1,s=e.cols,e.colsLength=s.length;for(var i=0;i<e.colsLength;++i){var g=s[i];g.flex&&(e.flexStart<0&&(e.flexStart=i),e.flexEnd=i)}0===e.flexStart&&e.flexEnd===e.colsLength&&(e.flexStart=-1,e.flexEnd=-1),e.flexArea=e.flexStart>=0,e.fixedRight=e.flexEnd>=0&&e.flexEnd<e.colsLength-1,e.fixedLeft=e.flexStart>0,e.flexStart<0&&e.flexEnd<0&&(e.fixedLeft=!0,e.flexStart=e.colsLength,e.flexEnd=e.colsLength),this.data=e,this.callEvent("afterLoad",{data:e}),this.render()},s.prototype.render=function(){var e,s,l,d,i=this,r=i.$datatable||(i.isTable?a('<div class="datatable" id="'+i.id+'"/>'):i.$datatable),o=i.options,n=i.data,c=i.data.cols,h=i.data.rows,f=o.checkable,p='<div class="datatable-rows-span datatable-span"><div class="datatable-wrapper"><table class="table"></table></div></div>',b='<div class="datatable-head-span datatable-span"><div class="datatable-wrapper"><table class="table"><thead></thead></table></div></div>';r.children(".datatable-head, .datatable-rows, .scroll-wrapper").remove(),r.toggleClass("sortable",o.sortable);var g,v,w,x=a('<div class="datatable-head"/>');for(e=a('<tr class="datatable-row datatable-row-left"/>'),l=a('<tr class="datatable-row datatable-row-right"/>'),d=a('<tr class="datatable-row datatable-row-flex"/>'),s=0;s<c.length;s++)w=c[s],g=s<n.flexStart?e:s>=n.flexStart&&s<=n.flexEnd?d:l,0===s&&f&&g.append('<th data-index="check" class="check-all check-btn"><i class="icon-check-empty"></i></th>'),w.ignore||(v=a('<th class="datatable-head-cell"/>'),v.toggleClass("sort-down","down"===w.sort).toggleClass("sort-up","up"===w.sort).toggleClass("sort-disabled",w.sort===!1),v.addClass(w.cssClass).addClass(w.colClass).html(w.text).attr({"data-index":s,"data-type":w.type,style:w.css,title:w.title}).css("width",w.width),g.append(v));var u;n.fixedLeft&&(u=a(b),u.addClass("fixed-left").find("table").addClass(o.tableClass).find("thead").append(e),x.append(u)),n.flexArea&&(u=a(b),u.addClass("flexarea").find(".datatable-wrapper").append('<div class="scrolled-shadow scrolled-in-shadow"></div><div class="scrolled-shadow scrolled-out-shadow"></div>').find("table").addClass(o.tableClass).find("thead").append(d),x.append(u)),n.fixedRight&&(u=a(b),u.addClass("fixed-right").find("table").addClass(o.tableClass).find("thead").append(l),x.append(u)),r.append(x);var C,k,m,y,$,S,E,L,H=a('<div class="datatable-rows">'),A=h.length;e=a("<tbody/>"),l=a("<tbody/>"),d=a("<tbody/>");for(var R=0;R<A;++R){for(S=h[R],"undefined"==typeof S.id&&(S.id=R),S.index=R,C=a('<tr class="datatable-row"/>'),C.addClass(S.cssClass).toggleClass(o.checkedClass,!!S.checked).attr({"data-index":R,"data-id":S.id}),k=C.clone().addClass("datatable-row-flex"),m=C.clone().addClass("datatable-row-right"),C.addClass("datatable-row-left"),L=S.data.length,s=0;s<L;++s)E=S.data[s],s>0&&E.empty||(g=s<n.flexStart?C:s>=n.flexStart&&s<=n.flexEnd?k:m,0===s&&f&&($=a('<td data-index="check" class="check-row check-btn"><i class="icon-check-empty"></i></td>'),o.checkboxName&&$.append('<input class="hide" type="checkbox" name="'+o.checkboxName+'" value="'+S.id+'">'),g.append($)),c[s].ignore||(a.isPlainObject(E)?(E.row=R,E.index=s):E={text:E,row:R,index:s},S.data[s]=E,y=a('<td class="datatable-cell"/>'),y.html(E.text).addClass(E.cssClass).addClass(c[s].colClass).attr("colspan",E.colSpan).attr({"data-row":R,"data-index":s,"data-flex":!1,"data-type":c[s].type,style:E.css,title:E.title||""}).css("width",c[s].width),g.append(y)));e.append(C),d.append(k),l.append(m)}var T;n.fixedLeft&&(T=a(p),T.addClass("fixed-left").find("table").addClass(o.tableClass).append(e),H.append(T)),n.flexArea&&(T=a(p),T.addClass("flexarea").find(".datatable-wrapper").append('<div class="scrolled-shadow scrolled-in-shadow"></div><div class="scrolled-shadow scrolled-out-shadow"></div>').find("table").addClass(o.tableClass).append(d),H.append(T)),n.fixedRight&&(T=a(p),T.addClass("fixed-right").find("table").addClass(o.tableClass).append(l),H.append(T)),r.append(H),n.flexArea&&r.append('<div class="scroll-wrapper"><div class="scroll-slide scroll-pos-'+o.scrollPos+'"><div class="bar"></div></div></div>');var z=r.children(".datatable-footer").detach();n.footer?(r.append(a('<div class="datatable-footer"/>').append(n.footer)),n.footer=null):z.length&&r.append(z),i.$datatable=r.data(t,i),i.isTable&&i.firstShow&&(i.$table.attr("data-datatable-id",this.id).hide().after(r),i.firstShow=!1),i.bindEvents(),i.refreshSize(),i.callEvent("render")},s.prototype.bindEvents=function(){var t=this,s=this.data,l=this.options,d=this.$datatable,i=t.$dataSpans=d.children(".datatable-head, .datatable-rows").find(".datatable-span"),r=t.$rowsSpans=d.children(".datatable-rows").children(".datatable-rows-span"),o=t.$headSpans=d.children(".datatable-head").children(".datatable-head-span"),n=t.$cells=i.find(".datatable-head-cell,.datatable-cell"),c=t.$dataCells=n.filter(".datatable-cell");t.$headCells=n.filter(".datatable-head-cell");var h=t.$rows=t.$rowsSpans.find(".datatable-row");if(l.rowHover){var f=l.hoverClass;r.on("mouseenter",".datatable-cell",function(){c.filter("."+f).removeClass(f),h.filter("."+f).removeClass(f),h.filter('[data-index="'+a(this).addClass(f).data("row")+'"]').addClass(f)}).on("mouseleave",".datatable-cell",function(){c.filter("."+f).removeClass(f),h.filter("."+f).removeClass(f)})}if(l.colHover){var p=l.colHoverClass;o.on("mouseenter",".datatable-head-cell",function(){n.filter("."+p).removeClass(p),n.filter('[data-index="'+a(this).data("index")+'"]').addClass(p)}).on("mouseleave",".datatable-head-cell",function(){n.filter("."+p).removeClass(p)})}if(s.flexArea){var b,g,v,w,x,u,C=d.find(".scroll-slide"),k=d.find(".datatable-span.flexarea"),m=d.find(".datatable-span.fixed-left"),y=d.find(".datatable-span.flexarea .table-datatable"),$=C.children(".bar"),S=t.id+"_scrollOffset";t.width=d.width(),d.resize(function(){t.width=d.width()});var E=function(a,t){w=Math.max(0,Math.min(b-g,a)),t||d.addClass("scrolling"),$.css("left",w),u=0-Math.floor((v-b)*w/(b-g)),y.css("left",u),d.toggleClass("scrolled-in",w>2).toggleClass("scrolled-out",w<b-g-2),l.storage&&e.pageSet(S,w)},L=function(){b=k.width()-2,C.width(b).css("left",m.width()),v=0,y.first().find("tr:first").children("td,th").each(function(){v+=a(this).outerWidth()}),g=Math.floor(b*b/v),$.css("width",g),y.css("min-width",Math.max(b,v)),d.toggleClass("show-scroll-slide",v>b),x||b===g||(x=!0,E(e.pageGet(S,0),!0)),d.hasClass("size-changing")&&E(w,!0)};k.resize(L),l.storage&&L();var H={move:!1,stopPropagation:!0,drag:function(a){E($.position().left+a.smallOffset.x*(a.element.hasClass("bar")?1:-1))},finish:function(){d.removeClass("scrolling")}};a.fn.draggable?($.draggable(H),l.flexHeadDrag&&d.find(".datatable-head-span.flexarea").draggable(H)):console.error("DataTable requires draggable.js to improve UI."),C.mousedown(function(a){var t=a.pageX-C.offset().left;E(t-g/2)})}if(l.checkable){var A,R=t.id+"_checkedStatus",T=l.checkedClass,z=function(){var d=r.first().find(".datatable-row"),i=d.filter("."+T);l.checkboxName&&d.find(".check-row input:checkbox").prop("checked",!1);var n={checkedAll:d.length===i.length&&i.length>0,checks:i.map(function(){return A=a(this).data("id"),l.checkboxName&&a(this).find(".check-row input:checkbox").prop("checked",!0),A}).toArray()};t.checks=n,a.each(s.rows,function(t,e){e.checked=a.inArray(e.id,n.checks)>-1}),o.find(".check-all").toggleClass("checked",!!n.checkedAll),l.storage&&e.pageSet(R,n),t.callEvent("checksChanged",{checks:n})},O=function(t,e){var s=a(t).closest("tr");void 0===e&&(e=!s.hasClass(T)),h.filter('[data-index="'+s.data("index")+'"]').toggleClass(T,!!e)},F="click.zui.datatable.check";if(l.selectable){var N={selector:".datatable-rows .datatable-row",trigger:".datatable-rows",start:function(t){var e=a(t.target).closest(".check-row, .check-btn");if(e.length)return e.is(".check-row")&&(O(e),z()),!1},rangeFunc:function(a,t){return Math.max(a.top,t.top)<Math.min(a.top+a.height,t.top+t.height)},select:function(a){O(a.target,!0)},unselect:function(a){O(a.target,!1)},finish:function(a){z()}};a.isPlainObject(l.selectable)&&a.extend(N,l.selectable),this.$datatable.selectable(N)}else this.$rowsSpans.off(F).on(F+"row",l.checkByClickRow?"tr":".check-row",function(){O(this),z()});if(this.$datatable.off(F).on("click.zui.datatable.check",".check-all",function(){h.toggleClass(T,a(this).toggleClass("checked").hasClass("checked")),z()}).on(F+".none",".check-none",function(){h.toggleClass(T,!1),z()}).on(F+".inverse",".check-inverse",function(){h.toggleClass(T),z()}),l.storage){var W=e.pageGet(R);W&&(o.find(".check-all").toggleClass("checked",W.checkedAll),W.checkedAll?h.addClass(T):(h.removeClass(T),a.each(W.checks,function(a,t){h.filter('[data-id="'+t+'"]').addClass(T)})),W.checks.length&&z())}}if(l.fixedHeader){var M,j,D,P=d.children(".datatable-head"),B=l.fixedHeaderOffset||a(".navbar.navbar-fixed-top").height()||0,G=function(){M=d.offset().top,D=a(window).scrollTop(),j=d.height(),d.toggleClass("head-fixed",D+B>M&&D+B<M+j),d.hasClass("head-fixed")?P.css({width:d.width(),top:B}):P.attr("style","")};a(window).scroll(G),G()}l.sortable?(o.on("click","th:not(.sort-disabled, .check-btn)",function(){d.hasClass("size-changing")||t.sortTable(a(this))}),l.storage&&t.sortTable()):l.mergeRows&&this.mergeRows()},s.prototype.mergeRows=function(){for(var t=this.$rowsSpans.find(".datatable-cell"),e=this.data.cols,s=0;s<e.length;s++){var l=e[s];if(l.mergeRows){var d=t.filter('[data-index="'+s+'"]');if(d.length>1){var i,r;d.each(function(){var t=a(this);i&&t.html()===i.html()?(r=i.attr("rowspan")||1,"number"!=typeof r&&(r=parseInt(r),isNaN(r)&&(r=1)),i.attr("rowspan",r+1).css("vertical-align","middle"),t.remove()):i=t})}}}},s.prototype.sortTable=function(t){var e=a.zui.store,s=this.options,l=this.id+"_datatableSorter",d=s.storage?e.pageGet(l):null;if(t||(t=d?this.$headCells.filter('[data-index="'+d.index+'"]').addClass("sort-"+("up"===d.type?"down":"up")):this.$headCells.filter(".sort-up, .sort-down").first()),t.length){var i,r,o,n=this.data,c=n.cols,h=n.rows,f=this.$headCells;i=!t.hasClass("sort-up"),n.keepSort&&(i=!i),n.keepSort=null,f.removeClass("sort-up sort-down"),t.addClass(i?"sort-up":"sort-down"),o=t.data("index"),a.each(c,function(a,t){a==o||"up"!==t.sort&&"down"!==t.sort?a==o&&(t.sort=i?"up":"down",r=t.type):t.sort=!0});var p,b,g,v=this.$dataCells.filter('[data-index="'+o+'"]');h.sort(function(a,t){return a=a.data[o],t=t.data[o],p=v.filter('[data-row="'+a.row+'"]').text(),b=v.filter('[data-row="'+t.row+'"]').text(),"number"===r?(p=parseFloat(p),b=parseFloat(b)):"date"===r?(p=Date.parse(p),b=Date.parse(b)):(p=p.toLowerCase(),b=b.toLowerCase()),g=p<b?1:p>b?-1:0,i&&(g*=-1),g});var w,x,u,C=this.$rows,k=[];a.each(h,function(t,e){w=C.filter('[data-index="'+e.index+'"]'),w.each(function(t){u=a(this),x=k[t],x?x.after(u):u.parent().prepend(u),k[t]=u})}),d={index:o,type:i?"up":"down"},s.storage&&e.pageSet(l,d),this.callEvent("sort",{sorter:d})}},s.prototype.refreshSize=function(){var t,e=this.$datatable,s=this.options,l=this.data.rows;this.data.cols;if(e.find(".datatable-span.fixed-left").css("width",s.fixedLeftWidth),e.find(".datatable-span.fixed-right").css("width",s.fixedRightWidth),s.fixCellHeight){var d=function(t){var e,s,l=0;return t.css("height","auto"),t.each(function(){e=a(this),s=e.attr("rowspan"),s&&1!=s||(l=Math.max(l,e.outerHeight()))}),l},i=this.$dataCells,r=(this.$cells,this.$headCells),o=d(r);r.css("min-height",o).css("height",o);var n;for(t=0;t<l.length;++t){n=i.filter('[data-row="'+t+'"]');var c=d(n);n.css("min-height",c).css("height",c)}}},s.prototype.callEvent=function(a,t){var e=this.$.callEvent(a+"."+this.name,t,this).result;return!(void 0!==e&&!e)},a.fn.datatable=function(e,l){return this.each(function(){var d=a(this),i=d.data(t),r="object"==typeof e&&e;i||d.data(t,i=new s(this,r)),"string"==typeof e&&("load"!==e||!a.isPlainObject(l)||void 0!==l.keepSort&&null!==l.keepSort||(l.keepSort=!0),i[e](l))})},a.fn.datatable.Constructor=s}(jQuery);