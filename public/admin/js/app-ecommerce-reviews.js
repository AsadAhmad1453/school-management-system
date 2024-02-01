"use strict";!function(){let e,t,a,o;t=isDarkStyle?(e=config.colors_dark.cardColor,a=config.colors_dark.textMuted,o=config.colors_dark.headingColor,"dark"):(e=config.colors.cardColor,a=config.colors.textMuted,o=config.colors.headingColor,"");var s=document.querySelector("#reviewsChart"),r={chart:{height:160,width:190,type:"bar",toolbar:{show:!1}},plotOptions:{bar:{barHeight:"75%",columnWidth:"40%",startingShape:"rounded",endingShape:"rounded",borderRadius:5,distributed:!0}},grid:{show:!1,padding:{top:-25,bottom:-12}},colors:[config.colors_label.success,config.colors_label.success,config.colors_label.success,config.colors_label.success,config.colors.success,config.colors_label.success,config.colors_label.success],dataLabels:{enabled:!1},series:[{data:[20,40,60,80,100,80,60]}],legend:{show:!1},xaxis:{categories:["M","T","W","T","F","S","S"],axisBorder:{show:!1},axisTicks:{show:!1},labels:{style:{colors:a,fontSize:"13px"}}},yaxis:{labels:{show:!1}},responsive:[{breakpoint:0,options:{chart:{width:"100%"},plotOptions:{bar:{columnWidth:"40%"}}}},{breakpoint:1440,options:{chart:{height:150,width:190,toolbar:{show:!1}},plotOptions:{bar:{borderRadius:6,columnWidth:"40%"}}}},{breakpoint:1400,options:{plotOptions:{bar:{borderRadius:6,columnWidth:"40%"}}}},{breakpoint:1200,options:{chart:{height:130,width:190,toolbar:{show:!1}},plotOptions:{bar:{borderRadius:6,columnWidth:"40%"}}}},{breakpoint:992,chart:{height:150,width:190,toolbar:{show:!1}},options:{plotOptions:{bar:{borderRadius:5,columnWidth:"40%"}}}},{breakpoint:883,options:{plotOptions:{bar:{borderRadius:5,columnWidth:"40%"}}}},{breakpoint:768,options:{chart:{height:150,width:190,toolbar:{show:!1}},plotOptions:{bar:{borderRadius:4,columnWidth:"40%"}}}},{breakpoint:576,options:{chart:{width:"100%",height:"200",type:"bar"},plotOptions:{bar:{borderRadius:6,columnWidth:"30% "}}}},{breakpoint:420,options:{plotOptions:{chart:{width:"100%",height:"200",type:"bar"},bar:{borderRadius:3,columnWidth:"30%"}}}}]};null!==s&&new ApexCharts(s,r).render()}(),$(function(){let t,a,o;o=(isDarkStyle?(t=config.colors_dark.borderColor,a=config.colors_dark.bodyBg,config.colors_dark):(t=config.colors.borderColor,a=config.colors.bodyBg,config.colors)).headingColor;var e,s=$(".datatables-review"),r={Pending:{title:"Pending",class:"bg-label-warning"},Published:{title:"Published",class:"bg-label-success"}};s.length&&(e=s.DataTable({ajax:assetsPath+"json/app-ecommerce-reviews.json",columns:[{data:""},{data:"id"},{data:"product"},{data:"reviewer"},{data:"review"},{data:"date"},{data:"status"},{data:" "}],columnDefs:[{className:"control",searchable:!1,orderable:!1,responsivePriority:2,targets:0,render:function(e,t,a,o){return""}},{targets:1,orderable:!1,searchable:!1,responsivePriority:3,checkboxes:!0,checkboxes:{selectAllRender:'<input type="checkbox" class="form-check-input">'},render:function(){return'<input type="checkbox" class="dt-checkboxes form-check-input">'}},{targets:2,render:function(e,t,a,o){var s=a.product,r=a.company_name,n=a.id,i=a.product_image;return'<div class="d-flex justify-content-start align-items-center customer-name"><div class="avatar-wrapper"><div class="avatar me-2 rounded-2 bg-label-secondary">'+(i?'<images src="'+assetsPath+"images/ecommerce-images/"+i+'" alt="Product-'+n+'" class="rounded-2">':'<span class="avatar-initial rounded bg-label-'+["success","danger","warning","info","dark","primary","secondary"][Math.floor(6*Math.random())]+'">'+(i=(((i=(s=a.product).match(/\b\w/g)||[]).shift()||"")+(i.pop()||"")).toUpperCase())+"</span>")+'</div></div><div class="d-flex flex-column"><span class="fw-medium text-nowrap">'+s+'</span></a><small class="text-muted">'+r+"</small></div></div>"}},{targets:3,responsivePriority:1,render:function(e,t,a,o){var s=a.reviewer,r=a.email,n=a.avatar;return'<div class="d-flex justify-content-start align-items-center customer-name"><div class="avatar-wrapper"><div class="avatar me-2">'+(n?'<images src="'+assetsPath+"images/avatars/"+n+'" alt="Avatar" class="rounded-circle">':'<span class="avatar-initial rounded-circle bg-label-'+["success","danger","warning","info","dark","primary","secondary"][Math.floor(6*Math.random())]+'">'+(n=(((n=(s=a.reviewer).match(/\b\w/g)||[]).shift()||"")+(n.pop()||"")).toUpperCase())+"</span>")+'</div></div><div class="d-flex flex-column"><a href="app-ecommerce-customer-details-overview.html"><span class="fw-medium">'+s+'</span></a><small class="text-muted text-nowrap">'+r+"</small></div></div>"}},{targets:4,responsivePriority:2,render:function(e,t,a,o){var s=a.review,r=a.head,a=a.para,n=$('<div class="read-only-ratings ps-0 mb-2"></div>');return n.rateYo({rating:s,rtl:isRtl,readOnly:!0,starWidth:"20px",spacing:"3px",starSvg:'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12,2 L15.09,8.09 L22,9.9 L17,14 L18.18,20 L12,17.5 L5.82,20 L7,14 L2,9.9 L8.91,8.09 L12,2 Z" /></svg>'}),"<div>"+n.prop("outerHTML")+'<p class="fw-medium mb-1 text-truncate text-capitalize">'+r+'</p><small class="text-break pe-3">'+a+"</small></div>"}},{targets:5,render:function(e,t,a,o){return'<span class="text-nowrap">'+new Date(a.date).toLocaleDateString("en-US",{month:"short",day:"numeric",year:"numeric"})+"</span>"}},{targets:6,render:function(e,t,a,o){a=a.status;return'<span class="badge '+r[a].class+'" text-capitalized>'+r[a].title+"</span>"}},{targets:-1,title:"Actions",searchable:!1,orderable:!1,render:function(e,t,a,o){return'<div class="text-xxl-center"><div class="dropdown"><a href="javascript:;" class="btn dropdown-toggle hide-arrow text-body p-0" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></a><div class="dropdown-menu dropdown-menu-end"><a href="javascript:;" class="dropdown-item">Download</a><a href="javascript:;" class="dropdown-item">Edit</a><a href="javascript:;" class="dropdown-item">Duplicate</a><div class="dropdown-divider"></div><a href="javascript:;" class="dropdown-item delete-record text-danger">Delete</a></div></div></div>'}}],order:[[2,"asc"]],dom:'<"card-header d-flex align-items-md-center pb-md-2 flex-wrap"<"me-5 ms-n2"f><"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-end align-items-md-center justify-content-md-end pt-0 gap-3 flex-wrap"l<"review_filter"> <"mx-0 me-md-n3 mt-sm-0"B>>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',language:{sLengthMenu:"_MENU_",search:"",searchPlaceholder:"Search Review"},buttons:[{extend:"collection",className:"btn btn-label-secondary dropdown-toggle me-3",text:'<i class="bx bx-export me-1"></i>Export',buttons:[{extend:"print",text:'<i class="bx bx-printer me-2" ></i>Print',className:"dropdown-item",exportOptions:{columns:[1,2,3,4,5,6],format:{body:function(e,t,a){var o;return e.length<=0?e:(e=$.parseHTML(e),o="",$.each(e,function(e,t){void 0!==t.classList&&t.classList.contains("customer-name")?o+=t.lastChild.firstChild.textContent:void 0===t.innerText?o+=t.textContent:o+=t.innerText}),o)}}},customize:function(e){$(e.document.body).css("color",o).css("border-color",t).css("background-color",a),$(e.document.body).find("table").addClass("compact").css("color","inherit").css("border-color","inherit").css("background-color","inherit")}},{extend:"csv",text:'<i class="bx bx-file me-2" ></i>Csv',className:"dropdown-item",exportOptions:{columns:[1,2,3,4,5,6],format:{body:function(e,t,a){var o;return e.length<=0?e:(e=$.parseHTML(e),o="",$.each(e,function(e,t){void 0!==t.classList&&t.classList.contains("customer-name")?o+=t.lastChild.firstChild.textContent:void 0===t.innerText?o+=t.textContent:o+=t.innerText}),o)}}}},{extend:"excel",text:'<i class="bx bxs-file-export me-2"></i>Excel',className:"dropdown-item",exportOptions:{columns:[1,2,3,4,5,6],format:{body:function(e,t,a){var o;return e.length<=0?e:(e=$.parseHTML(e),o="",$.each(e,function(e,t){void 0!==t.classList&&t.classList.contains("customer-name")?o+=t.lastChild.firstChild.textContent:void 0===t.innerText?o+=t.textContent:o+=t.innerText}),o)}}}},{extend:"pdf",text:'<i class="bx bxs-file-pdf me-2"></i>Pdf',className:"dropdown-item",exportOptions:{columns:[1,2,3,4,5,6],format:{body:function(e,t,a){var o;return e.length<=0?e:(e=$.parseHTML(e),o="",$.each(e,function(e,t){void 0!==t.classList&&t.classList.contains("customer-name")?o+=t.lastChild.firstChild.textContent:void 0===t.innerText?o+=t.textContent:o+=t.innerText}),o)}}}},{extend:"copy",text:'<i class="bx bx-copy me-2" ></i>Copy',className:"dropdown-item",exportOptions:{columns:[1,2,3,4,5,6],format:{body:function(e,t,a){var o;return e.length<=0?e:(e=$.parseHTML(e),o="",$.each(e,function(e,t){void 0!==t.classList&&t.classList.contains("customer-name")?o+=t.lastChild.firstChild.textContent:void 0===t.innerText?o+=t.textContent:o+=t.innerText}),o)}}}}]}],responsive:{details:{display:$.fn.dataTable.Responsive.display.modal({header:function(e){return"Details of "+e.data().reviewer}}),type:"column",renderer:function(e,t,a){a=$.map(a,function(e,t){return""!==e.title?'<tr data-dt-row="'+e.rowIndex+'" data-dt-column="'+e.columnIndex+'"><td>'+e.title+":</td> <td>"+e.data+"</td></tr>":""}).join("");return!!a&&$('<table class="table"/><tbody />').append(a)}}},initComplete:function(){this.api().columns(6).every(function(){var t=this,a=$('<select id="Review" class="form-select"><option value=""> All </option></select>').appendTo(".review_filter").on("change",function(){var e=$.fn.dataTable.util.escapeRegex($(this).val());t.search(e?"^"+e+"$":"",!0,!1).draw()});t.data().unique().sort().each(function(e,t){a.append('<option value="'+e+'" class="text-capitalize">'+e+"</option>")})})}}),$(".dataTables_length").addClass("mt-0 mt-md-3"),$(".dt-buttons > .btn-group > button").removeClass("btn-secondary")),$(".datatables-review tbody").on("click",".delete-record",function(){e.row($(this).parents("tr")).remove().draw()}),setTimeout(()=>{$(".dataTables_filter .form-control").removeClass("form-control-sm"),$(".dataTables_length .form-select").removeClass("form-select-sm")},300)});