function elem(element,args){
  let edens = new Object;
  if(undefined===args){args=new Object;}
  if(undefined===element){edens.elem = document.createElement('div');}
  else if(undefined!==element.innerHTML){edens.elem=element;}
  else if(['.','#'].includes(element.charAt(0))){edens.elem=document.querySelector(element);}
  else{
    let acrear='div'
    if(['btngroup','uk-card','dropdown_presentacion','select_','table_','btngroup','navbar','MainRight','Epanel','columns','column','form-stacked','alert'].includes(element)){acrear='div';}
    else if(element=='label'){acrear='label';}
    else if(['ul','subnav','list','accordion'].includes(element)){acrear='ul';}
    else if(['faicon'].includes(element)){acrear='i';}
    else if(['checkbox'].includes(element)){acrear='input';}
    else{acrear=element;}
    edens.elem=document.createElement(acrear);
  }
  Object.entries(args).forEach(function(v,k){
    if (['type','name','title','href','id','src','value','className','placeholder'].includes(v[0])) {
      edens.elem[v[0]] = v[1];
      return;
    }
    if (v[0]=='style') {
      Object.entries(v[1]).forEach((style) => {
        edens.elem.style[style[0]] = style[1];
      });

    }
    if (['html','innerHTML','content'].includes(v[0])) {
      switch (typeof v[1]) {
        case 'string':edens.elem.innerHTML = v[1];break;
        case 'number':edens.elem.innerHTML = v[1];break;
        case 'object':
        if (undefined!==v[1].innerHTML) {
          edens.elem.appendChild(v[1]);
        }
        break;
      }
      return;
    }
    if (v[0]=='attr'){Object.entries(v[1]).forEach(function(attr){edens.elem.setAttribute(attr[0],attr[1]);});return;}
    if (v[0]=='appendTo'){v[1].appendChild(edens.elem);return;}
    if (v[0]=='prependTo'){v[1].prepend(edens.elem);return;}
    if (v[0]=='afterTo'){
      v[1].parentElement.insertBefore(edens.elem,v[1].nextElementSibling)
      return;}
      if (v[0]=='on') {
        Object.entries(v[1]).forEach(function(evento){
          edens.elem[evento[0]] = function(evt){
            evento[1](evt)
            evt.preventDefault()
          }
        });
        return;
      }
      if (['onclick','onkeyup'].includes(v[0])) {
        edens.elem[v[0]] = function(evt){
          v[1](evt)
          evt.preventDefault()
        }
        return;
      }
      if (v[0]=='elements') {
        Object.values(v[1]).forEach(function(v2){
          let el = elem(v2.element,v2.args);
          edens.elem.appendChild(el);
        });
        return;
      }
    });
    switch (element) {
      case 'btngroup':
        edens.elem.classList.add('field');
        edens.elem.classList.add('has-addons');
        if (undefined!==args.buttons) {
          args.buttons.forEach((button) => {
            let control = elem('p',{appendTo:edens.elem,className:'control'});
            let btn = elem('button',button)
            control.appendChild(btn);
          });
        }
        break;
      case 'uk-card':
        edens.elem.classList.add("uk-card");
        edens.elem.classList.add("uk-card-default");
        edens.elem.classList.add("uk-width-1-1");
        if (undefined!==args.header) {
          let header_ = elem('div',args.header);
          header_.classList.add("uk-card-header");
          header_.classList.add("uk-padding-small");
          edens.elem.appendChild(header_);
          if (undefined!==args.header.title) {
            let title_ = elem('h3',args.header.title);
            title_.classList.add('uk-card-title')
            title_.classList.add('is-size-5')
            header_.appendChild(title_);
          }
        }
        if (undefined!==args.body) {
          let body_ = elem('div',args.body);
          body_.classList.add("uk-card-body");
          edens.elem.appendChild(body_);
        }
        if (undefined!==args.footer) {
          let footer_ = elem('div',args.footer);
          body_.classList.add("uk-card-footer");
          edens.elem.appendChild(footer_);
        }
        break;
      case 'accordion':
        if (undefined==args.attr) {
          edens.elem.setAttribute("uk-accordion","");
        }
        if (undefined!==args.items) {
          args.items.forEach((item, i) => {
            let args_li = {};
            if (undefined!==item.li) {args_li=item.li}
            let li = elem('li',args_li);
            edens.elem.appendChild(li);
            if (undefined!==item.title) {
              let title = elem('a',item.title)
              title.classList.add("uk-accordion-title");
              title.href="#";
              li.appendChild(title);
            }
            if (undefined!==item.body) {
              let body = elem('div',item.body)
              body.classList.add("uk-accordion-content");
              li.appendChild(body);
            }
          });

        }
        break;
      case 'dropdown_presentacion':
        edens.elem.classList.add('uk-inline');
        edens.elem.classList.add('uk-margin-remove');
        if (undefined!==args.icon) {
          elem('a',{
            appendTo:edens.elem,
            className:'is-small is-info uk-invisible-hover uk-align-right uk-margin-remove',
            attr:{"uk-icon":"icon: "+args.icon},
          })
        }
        if (undefined!==args.dropdown) {
          let drop = elem('div',args.dropdown);
          drop.classList.add("uk-padding-small");
          edens.elem.appendChild(drop);
        }
        break;
      case 'td':
        edens.elem.classList.add("uk-visible-toggle")
        break;
      case 'select':
        if (undefined!==args.options) {
          args.options.forEach((item, i) => {
            let opt = elem('option',item);
            edens.elem.appendChild(opt);
          });

        }
        break;
      case 'select_':
        edens.elem.classList.add("field");
        let control = elem('div',{appendTo:edens.elem,className:'control has-icons-left',})

        // if (undefined!==args.div_select) {
        //
        // }
        let div_select_args = {appendTo:control}
        if (undefined!==args.div_select) {
          if (undefined==args.div_select.appendTo) {args.div_select.appendTo = control;}
        }
        let div_select = elem('div',div_select_args)
        if (undefined!==args.select) {
          let sel = elem('select',args.select);
          div_select.appendChild(sel)
        }
        div_select.classList.add("select")
        div_select.classList.add("is-fullwidth")
        break;
      case 'btngroup':
        edens.elem.classList.add("field");
        edens.elem.classList.add("has-addons");
        if (undefined!==args.buttons) {
          args.buttons.forEach((button) => {
            let control_ = elem('p',{
              appendTo:edens.elem,
              className:'control'
            })
            let button_ = elem('button',button)
            control_.appendChild(button_);
          });

        }
        break;
      case 'tr':
        if (undefined!==args.th) {
          args.th.forEach((td) => {
            let td_ = elem('th',td)
            edens.elem.appendChild(td_)
          });
        }
        if (undefined!==args.td) {
          args.td.forEach((td) => {
            let td_ = elem('td',td)
            edens.elem.appendChild(td_)
          });
        }
        break;
      case 'table_':
        edens.elem.classList.add("uk-overflow-auto");
        if (undefined!==args.table) {
          let tbl = elem('table',args.table);
          edens.elem.appendChild(tbl)
        }
        break;
      case 'table':
        edens.elem.classList.add("uk-table")
        edens.elem.classList.add("uk-table-small")
        edens.elem.classList.add("uk-table-divider")
        edens.elem.classList.add("uk-table-middle")
        // edens.elem.classList.add("uk-visible-toggle")
        if (undefined!==args.thead) {
          thead = elem('thead',{
            appendTo:edens.elem,
            elements:[
              {
                element:'tr',
                args:{
                  td:args.thead
                }
              }
            ]
          })
          edens.elem.appendChild(thead)
        }
        let tbody_ = elem('tbody',{appendTo:edens.elem})
        if (undefined!==args.tbody) {
          args.tbody.forEach((tr) => {
            let tr_ = elem('tr',tr);
            tbody_.appendChild(tr_);
          });


        }
        break;
      case 'button':
        edens.elem.classList.add("button");
        if (undefined!==args.icon) {
          elem('span',{
            appendTo:edens.elem,
            className:'icon is-small',
            elements:[
              {
                element:'faicon',
                args:args.icon
              }
            ]
          })
        }
        break;
      case 'alert':
        edens.elem.setAttribute("uk-alert","");
        msg="";
        if (undefined!==args.type) {
          mclass = "";
          switch (args.type) {
            case 'error':mclass = "uk-alert-danger";msg="ERROR";break;
            case 'warn':mclass = "uk-alert-warning";msg="WARNING";break;
            case 'success':mclass = "uk-alert-success";msg="SUCCESS";break;
            case 'ok':mclass = "uk-alert-success";msg="SUCCESS";break;
            default:
            mclass = "uk-alert-primary";msg="INFORMATION";
          }
        }
        edens.elem.classList.add(mclass)
        if (undefined!==args.content) {msg=args.content;}
        elem('a',{
          appendTo:edens.elem,
          className:'uk-alert-close',
          attr:{"uk-close":""}
        })
        break;
      case 'form-stacked':
      edens.elem.classList.add('uk-margin');
      let idfor = makeid();
      if (undefined!==args.label) {
        elem('label',{
          appendTo:edens.elem,
          className:'uk-form-label is-size-6',
          attr:{
            for:idfor
          },
          innerHTML:args.label
        })
      }
      let fcontrol = elem('div',{
        appendTo:edens.elem,
        className:'uk-form-controls'
      });
      if (undefined!==args.select_) {
        let select_ = elem('select_',args.select_)
        select_.id=idfor;
        edens.elem.appendChild(select_);
      }
      if (undefined!==args.input) {
        let input = elem('input',args.input)
        input.id=idfor;
        edens.elem.appendChild(input);
      }
      if (undefined!==args.textarea) {
        let textarea = elem('textarea',args.textarea)
        textarea.id=idfor;
        edens.elem.appendChild(textarea);
      }
      if (undefined!==args.control) {args.control(fcontrol)}
        break;
      case 'input':
        if (undefined!==args.type) {
          if (args.type=='number') {edens.elem.setAttribute("step","any");}
          if (['date','number'].includes(args.type)) {
            edens.elem.classList.add("uk-input")
            edens.elem.classList.add("input")
            // edens.elem.classList.add("uk-form-small")
            if (undefined!==args.valueAsNumber) {
              edens.elem.valueAsNumber = args.valueAsNumber;
            }
          }
          switch (args.type) {
            case 'radio':
            edens.elem.classList.add("uk-radio")
            break;
            case 'checkbox':
            edens.elem.classList.add("uk-checkbox")
            break;
            default:
            edens.elem.classList.add("uk-input")
            // edens.elem.classList.add("uk-form-small")
          }
        }else{
          edens.elem.className = "uk-input"
          // edens.elem.className = "uk-input uk-form-small"
        }
        break;
      case 'checkbox':
        edens.elem.classList.add("uk-checkbox")
        edens.elem.type="checkbox"
        break;
      case 'textarea':
        edens.elem.classList.add("uk-textarea")


        break;
      case 'list':
        edens.elem.classList.add('uk-list');
        edens.elem.classList.add('uk-list-divider');
        if (undefined!==args.items) {
          args.items.forEach((item) => {
            li = elem('li',item)
            edens.elem.appendChild(li)
          });

        }
        break;
      case 'column':
        edens.elem.classList.add('column');
        break;
      case 'columns':
        edens.elem.classList.add('columns');
        break;
      case 'subnav':
        edens.elem.className = "uk-subnav uk-subnav-pill subnav uk-margin-remove has-background-white-ter"
        if (undefined!==args.items) {
          args.items.forEach(function(item){
            if (undefined!==item.link) {
              item.content = elem('a',item.link)
              delete item.link;
            }
            let li = elem('li',item);
            li.classList.add("uk-padding-remove")
            edens.elem.appendChild(li);
          });
        }
        break;
  }
  if (undefined!==args.DOM || undefined!==args.dom) {
    args.dom(edens.elem);
  }
  return edens.elem;
}
/**
* Execute a function given a delay time
*
* @param {type} func
* @param {type} wait
* @param {type} immediate
* @returns {Function}
*/
var debounce = function (func, wait=500, immediate) {
  var timeout;
  return function() {
    var context = this, args = arguments;
    var later = function() {
      timeout = null;
      if (!immediate) func.apply(context, args);
    };
    var callNow = immediate && !timeout;
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
    if (callNow) func.apply(context, args);
  };
};
function AJAX(args){
  const dajax = {
    url:SITE_URL+args.url,
    type:undefined===args.type?'post':args.type,
    data:undefined===args.data?{}:args.data,
    xhr: function() {
      var xhr = new window.XMLHttpRequest();
      xhr.upload.addEventListener("progress", function(evt) {
        if (undefined!==args.upload) {
          args.upload(xhr,evt);
        }
      }, false);
      return xhr;
    },
    beforeSend:function(xhr,opts){
      if( undefined===sessionStorage.getItem('statusTime')|| null===sessionStorage.getItem('statusTime')){1}
    }
  }
  $.ajax(dajax).
  done(function(d){
    if (undefined!==d.error && d.error!==0) {
      alerta.error(d.errormsg);
      if(undefined!==args.errdone){args.errdone(d);}
      return;
    }
    if(undefined!==args.done){args.done(d);}
  }).
  fail(function(err,status,errorThrown){
    $("button,.button").removeClass('is-loading');
    console.log(err);
  }).
  always(function(err,status){
    if(undefined!==args.always){args.always(err,status)}
  })
}
function setfancyboximage(padre){
  $(padre).find("[data-fancybox]").fancybox({
    buttons : ['slideShow','zoom','fullScreen','close'],
    thumbs : {autoStart : true},
  });
}
var alerta = {
  fancybox:function(args){
    $.fancybox.open({
      type        : undefined==args.type?'html':args.type,
      src         : undefined==args.html?elem('div',{className:'uk-width-1-3@m uk-border-rounded'}):args.html,
      opts : {
        hideScrollbar: true,
        toolbar: false,
        // smallBtn : true,
        smallBtn : (undefined!==args.btnclose && args.btnclose==false)?false:true,
        afterShow : function( instance, current ) {
          if (undefined!==args.onShow) {
            let elemento = current["$content"][0];
            args.onShow(instance, current, elemento);
            setfancyboximage(elemento);
          }
        },
        afterClose:function(){
          if (undefined!==args.onClose) {args.onClose();}
        },
        clickOutside:false,
      }
    });
  },
  error:function(msg){
    alert(msg);
  },
  confirma:function(args){
    if (undefined==args) {args={}}
    args.text = undefined==args.text?'Confirme la accion a realizar':args.text;
    let isok = confirm(args.text);
    if (isok) {
      if (undefined!==args.ok) {args.ok();}
    }
  },
}

const OBJ = {}

var main = {
  ajax:{
    set:function(args){
      if (undefined==args) {args = {};}
      if (undefined==args.filtro) {alerta.error("ERROR FATAL: Defina filtro y controllers");return;}
      let controller = 'api.php?t=';
      args.controller = (undefined==args.controller)?controller:args.controller;
      args.url = (undefined==args.url)?`${args.controller}${args.filtro}&`:args.url;
      args.data = (undefined==args.data)?{}:args.data;
      AJAX({
        url:args.url,
        data:args.data,
        always:function(){
          if (undefined!==args.always) {args.always();}
        },
        done:function(resp){
          if (undefined!==args.done) {args.done(resp);}

          if (undefined!==args.fancybox) {
            alerta.fancybox({
              html:elem('div',{
                className:'uk-width-1-3@m uk-width-1-4@xl  uk-border-rounded',
                innerHTML: undefined==args.fancyboxHtml?resp.form:(undefined==resp[args.fancyboxHtml]?'':resp[args.fancyboxHtml]),
              }),
              onShow:function(i,c,e){
                args.fancybox(i,c,e);
              },
            })
          }
        }
      });
    },
  },
  init:function(){
    main.login.setlogin();
    main.categorias.setbtncrear();
    main.perfiles.setbcrearperfil();
  },
  logout:{
    init:function(){
      main.ajax.set({
        filtro:'logout',
        done:function(){
          location.reload();
        }
      });
    },
  },
  perfiles:{
    init:function(){
      main.ajax.set({
        filtro:'getperfiles',
        done:function(resp){
          $("[main-container]").html(resp.form).promise().done(function(){
            main.init();
          });
        }
      });
    },
    setbtnsperfiles:function(args){
      if (undefined==args) {
        args = {}
      }
      if (undefined==args.root) {
        args.root = $("[listar-perfiles]");
      }
      $(args.root).find("[btn-edit-perfil]").click(function(){
        let this_ = $(this);
        let data = {id:this_.attr('btn-edit-perfil')}
        this_.addClass('is-loading');
        main.ajax.set({
          filtro:'getformeditperfil',
          data:data,
          always:function(){this_.removeClass('is-loading');},
          done:function(resp){

            console.log(resp);

          },
        });

        console.log(data);

      });
      $(args.root).find("[btn-delete-perfil]").click(function(){
        let this_ = $(this);
        let data = {id:this_.attr('btn-delete-perfil')}
        alerta.confirma({
          ok:function(){
            this_.addClass('is-loading');
            main.ajax.set({
              filtro:'eliminarperfil',
              data:data,
              done:function(resp){
                main.perfiles.buscar({
                  done:function(){
                    this_.removeClass('is-loading');
                  }
                });
              },
            });
          }
        });
      });
    },
    buscar:function(args){
      if (undefined==args) {
        args = {}
      }
      if (undefined==args.data) {
        args.data = {val:''};
      }
      main.ajax.set({
        filtro:'buscarperfil',
        data:args.data,
        errdone:function(){if (undefined!==args.done) {args.done();}},
        done:function(resp){
          $("[listar-perfiles]").html(resp.form).promise().done(function(){
            main.perfiles.setbtnsperfiles();
            if (undefined!==args.done) {args.done();}
          });
        },
      });
    },
    setbcrearperfil:function(args){
      if (undefined==args) {
        args = {}
      }
      if (undefined==args.root) {
        args.root = $("body");
      }
      main.perfiles.setbtnsperfiles();
      $(args.root).find("[btn-add-perfil]").click(function(){
        let this_ = $(this);
        this_.addClass('is-loading');
        main.ajax.set({
          filtro:'getformcrearperfil',
          always:function(){this_.removeClass('is-loading');},
          fancybox:function(i,c,e){

            $(e).find("[btn-crear-perfil]").click(function(){
              let this_ = $(this);
              let errors = 0;
              let data = {}

              $(e).find("[name]").each(function(){
                let val = $(this).val();
                let name = $(this).attr('name');
                if ($(this).attr('type')=='checkbox') {
                  val = $(this).prop('checked')?"1":"0";
                }
                if (val.length>0) {$(this).removeClass('is-danger uk-form-danger');}
                else {$(this).addClass('is-danger uk-form-danger');errors += 1;}
                data[name] = val;
              });
              if (errors>0) {
                alerta.error("ERROR: Formulario");
                return;
              }
              this_.addClass('is-loading');
              main.ajax.set({
                filtro:'crearperfil',
                data:data,
                always:function(){this_.removeClass('is-loading');},
                done:function(resp){
                  main.perfiles.buscar({
                    done:function(){
                      $.fancybox.destroy();
                    }
                  });
                },
              });

            });
          },
        });

      });

    },
  },
  login:{
    init:function(){
      main.ajax.set({
        filtro:'getlogin',
        done:function(resp){
          $("[main-container]").html(resp.form).promise().done(function(){
            main.init();
          });
        }
      });
    },
    setlogin:function(){
      $("[main-login] [btn-login]").click(function(){
        let this_ = $(this);
        let data = {}
        let errors = 0;
        $("[main-login] [name]").each(function(){
          let val = $(this).val();
          let name = $(this).attr('name');
          $(this)[val.length>0?'removeClass':'addClass']('is-danger uk-form-danger');
          errors = errors+(val.length>0?0:1);
          data[name] = val;
        });
        if (errors>0) {
          alerta.error("ERROR: Formulario");
          return;
        }
        this_.addClass('is-loading');
        main.ajax.set({
          filtro:'login',
          data:data,
          always:function(){
            this_.removeClass('is-loading');
          },
          done:function(r){
            location.reload();
          }
        });
      });
    },
  },
  c_productos:{
    buscar:function(args){
      if (undefined==args) {args = {}}
      if (undefined==args.data) {args.data = {val:''};}
      main.ajax.set({
        filtro:'buscarproducto',
        data:args.data,
        done:function(resp){
          $("[listar-productos] tbody").html(resp.form).promise().done(function(){
            main.c_productos.setbtnseditproducto();
            if (undefined!==args.done) {args.done();}
          });
        },
      });
    },
    setbtnseditproducto:function(args){
      if (undefined==args) {
        args = {}
      }
      if (undefined==args.root) {
        args.root = $("[listar-productos]");
      }

      $(args.root).find("[btn-edit-producto]").click(function(){
        let this_ = $(this);
        let data = {id:this_.attr('btn-edit-producto')}
        this_.addClass('is-loading');
        main.ajax.set({
          filtro:'getformupdateproducto',
          data:data,
          always:function(){this_.removeClass('is-loading');},
          fancybox:function(i,c,e){

            $(e).find("[btn-update-producto]").click(function(){
              let this_ = $(this);
              let errors = 0;
              let data = {
                id:this_.attr('btn-update-producto'),
                categorias:[]
              }
              $(e).find("[name]").each(function(){
                let val = $(this).val();
                let name = $(this).attr('name');
                if (name=='estado') {
                  data[name] = $(this).prop('checked')?1:0;
                  return;
                }
                if (name=='idcategoria') {
                  if ($(this).prop('checked')) {
                    data.categorias.push(val);
                  }
                  return;
                }
                if (name!='descripcion') {
                  if (val.length>0) {$(this).removeClass('is-danger uk-form-danger');}
                  else{$(this).addClass('is-danger uk-form-danger');errors += 1;}
                }
                data[name] = val;
              });
              if (errors>0) {
                alerta.error("ERROR: Formulario");
                return;
              }
              this_.addClass('is-loading');
              main.ajax.set({
                filtro:'actualizarproducto',
                data:data,
                always:function(){this_.removeClass('is-loading');},
                done:function(resp){
                  main.c_productos.buscar({
                    data:{val:'',idcategoria:OBJ.categoria_opened},
                    done:function(){
                      $.fancybox.destroy();
                    },
                  });
                },
              });
            });
          },
        });
      });

      $(args.root).find("[btn-delete-producto]").click(function(){
        let this_ = $(this);
        let data = {id:this_.attr('btn-delete-producto')}
        alerta.confirma({
          ok:function(){
            this_.addClass('is-loading');
            main.ajax.set({
              filtro:'eliminarproducto',
              data:data,
              always:function(){this_.removeClass('is-loading');},
              done:function(resp){
                main.c_productos.buscar({
                  data:{
                    val:'',
                    idcategoria:OBJ.categoria_opened
                  },
                });
              },
            });
          }
        });
      });

    },
    setbtntop:function(args){
      if (undefined==args) {
        args = {}
      }
      if (undefined==args.root) {
        args.root = $("body");
      }
      main.c_productos.setbtnseditproducto();
      $(args.root).find("[input-search-prodcutos]").keyup(debounce(function(){
        let this_ = $(this);
        let data = {val:this_.val()}
        if (!$("[check-buscar-all]").prop('checked')) {
          data.idcategoria = OBJ.categoria_opened;
        }
        main.c_productos.buscar({
          data:data,
          done:function(resp){
            console.log(resp);
          },
        });
      }));
      $(args.root).find("[btn-add-producto]").click(function(){
        let this_ = $(this);
        this_.addClass('is-loading');
        main.ajax.set({
          filtro:'getformcrearproducto',
          always:function(){this_.removeClass('is-loading');},
          fancybox:function(i,c,e){
            $(e).find("[btn-crear-producto]").click(function(){
              let this_ = $(this);
              let errors = 0;
              let data = {
                categorias:[OBJ.categoria_opened]
              }
              $(e).find("[name]").each(function(){
                let val = $(this).val();
                let name = $(this).attr('name');
                if(['checkbox'].includes($(this).attr('type'))){
                  val = $(this).prop('checked')?"1":"0";
                }
                if(!$(this).is("textarea")){
                  $(this)[val.length>0?'removeClass':'addClass']('is-danger uk-form-danger');
                  errors = errors+(val.length>0?0:1);
                }
                data[name] = val;
              });
              if (errors>0) {
                alerta.error("ERROR: Formulario");
                return;
              }
              this_.addClass('is-loading');
              main.ajax.set({
                filtro:'crearproducto',
                data:data,
                always:function(){this_.removeClass('is-loading');},
                done:function(resp){
                  main.c_productos.buscar({
                    data:{val:'',idcategoria:OBJ.categoria_opened},
                    done:function(){
                      $.fancybox.destroy();
                    },
                  })
                }
              });
            });
          },
        });
      });
    },
  },
  categorias:{
    init:function(){
      main.ajax.set({
        filtro:'getcategorias',
        done:function(resp){
          $("[main-container]").html(resp.form).promise().done(function(){
            main.init();
          });
        }
      });
    },
    setbtnscategoria:function(args){
      if (undefined==args) {
        args = {}
      }
      if (undefined==args.root) {
        args.root = $("[listar-categorias]");
      }
      $(args.root).find("[btn-delete-categoria]").click(function(){
        let this_ = $(this);
        let data = {id:this_.attr('btn-delete-categoria')}
        alerta.confirma({
          text:'Desea eliminar la categoria?',
          ok:function(){
            this_.addClass('is-loading');
            main.ajax.set({
              filtro:'eliminarcategoria',
              data:data,
              always:function(){this_.removeClass('is-loading');},
              done:function(){
                main.categorias.buscar({
                  done:function(){
                    if (undefined!==OBJ.categoria_opened && OBJ.categoria_opened==data.id) {
                      $("[listar-productos]").html("");
                      delete OBJ.categoria_opened;
                    }
                  },
                });
              },
            });
          }
        });
      });
      $(args.root).find("[btn-edit-categoria]").click(function(){
        let this_ = $(this);
        let data = {
          id:this_.attr('btn-edit-categoria')
        }
        this_.addClass('is-loading');

        main.categorias.getformcategoria({
          filtro:'getformeditcategoria',
          data:data,
          done:function(){
            this_.removeClass('is-loading');
          },
        });

      });
      $(args.root).find("[btn-view-categoria]").click(function(){
        let this_ = $(this);
        let data = {id:this_.attr('btn-view-categoria')}
        this_.addClass('is-loading');
        main.ajax.set({
          filtro:'viewcategoria',
          data:data,
          always:function(){this_.removeClass('is-loading');},
          done:function(resp){
            OBJ.categoria_opened = data.id;
            $("[listar-productos]").html(resp.form).promise().done(function(){
              main.c_productos.setbtntop({root:$(this)});
            });
          },
        });
      });
    },
    buscar:function(args){
      if (undefined==args) {
        args = {}
      }
      if (undefined==args.data) {
        args.data = {val:''};
      }
      main.ajax.set({
        filtro:'buscarcategoria',
        data:args.data,
        done:function(resp){
          $("[listar-categorias]").html(resp.form).promise().done(function(){
            main.categorias.setbtnscategoria();
            if (undefined!==args.done) {args.done();}


          });
        },
      });
    },
    getformcategoria:function(args){
      if (undefined==args) {
        args = {}
      }
      if (undefined==args.data) {
        args.data = {}
      }
      args.filtro = undefined==args.filtro?'getformcrearcategoria':args.filtro;
      main.ajax.set({
        filtro:args.filtro,
        data:args.data,
        always:function(){
          if (undefined!==args.done) {args.done();}
        },
        fancybox:function(i,c,e){
          $(e).find("[btn-crear]").click(function(){
            let this_ = $(this);
            let errors = 0;
            let data = {}
            $(e).find("[name]").each(function(){
              let val = $(this).val();
              let name = $(this).attr('name');
              if(['checkbox'].includes($(this).attr('type'))){
                val = $(this).prop('checked')?"1":"0";
              }
              $(this)[val.length>0?'removeClass':'addClass']('is-danger uk-form-danger');
              errors = errors+(val.length>0?0:1);
              data[name] = val;
            });
            if (errors>0) {
              alerta.error("ERROR: Formulario");
              return;
            }
            main.ajax.set({
              filtro:'crearcategoria',
              data:data,
              done:function(resp){
                main.categorias.buscar({
                  done:function(){
                    $.fancybox.destroy();
                  }
                });
              }
            });
          });
          $(e).find("[btn-update]").click(function(){
            let this_ = $(this);
            let errors = 0;
            let data = {id:this_.attr('btn-update')}
            $(e).find("[name]").each(function(){
              let val = $(this).val();
              let name = $(this).attr('name');
              if(['checkbox'].includes($(this).attr('type'))){
                val = $(this).prop('checked')?"1":"0";
              }
              $(this)[val.length>0?'removeClass':'addClass']('is-danger uk-form-danger');
              errors = errors+(val.length>0?0:1);
              data[name] = val;
            });
            if (errors>0) {
              alerta.error("ERROR: Formulario");
              return;
            }
            main.ajax.set({
              filtro:'actualizarcategoria',
              data:data,
              done:function(resp){
                main.categorias.buscar({
                  done:function(){
                    $.fancybox.destroy();
                    if (undefined!==OBJ.categoria_opened && OBJ.categoria_opened==data.id) {
                      $(`[btn-view-categoria=${OBJ.categoria_opened}]`).click();
                    }
                  }
                });
              }
            });
          });
        },
      });
    },
    setbtncrear:function(){
      main.categorias.setbtnscategoria();
      $("[btn-add-categoria]").click(function(){
        let this_ = $(this);
        this_.addClass('is-loading');
        main.categorias.getformcategoria({
          done:function(){
            this_.removeClass('is-loading');
          },
        });
      });
      $("[input-search-categoria]").keyup(debounce(function(){
        let this_ = $(this);
        let data = {val:this_.val()}
        this_.parent().addClass('is-loading');
        main.categorias.buscar({
          data:data,
          done:function(){
            this_.parent().removeClass('is-loading');
          },
        });
      }));
    },
  },
  navbtn:function(){
    $("[btn-nav]").click(function(){
      let this_ = $(this);
      let t_ = this_.attr('btn-nav');
      if (undefined!==main[t_] && undefined!==main[t_].init) {
        main[t_].init();
      }
    });
  },

}


main.init();
main.navbtn();
