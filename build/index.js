/*! For license information please see index.js.LICENSE.txt */
!function(e){var r={};function t(n){if(r[n])return r[n].exports;var o=r[n]={i:n,l:!1,exports:{}};return e[n].call(o.exports,o,o.exports,t),o.l=!0,o.exports}t.m=e,t.c=r,t.d=function(e,r,n){t.o(e,r)||Object.defineProperty(e,r,{enumerable:!0,get:n})},t.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},t.t=function(e,r){if(1&r&&(e=t(e)),8&r)return e;if(4&r&&"object"==typeof e&&e&&e.__esModule)return e;var n=Object.create(null);if(t.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&r&&"string"!=typeof e)for(var o in e)t.d(n,o,function(r){return e[r]}.bind(null,o));return n},t.n=function(e){var r=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(r,"a",r),r},t.o=function(e,r){return Object.prototype.hasOwnProperty.call(e,r)},t.p="",t(t.s="./src/index.js")}({"./node_modules/object-assign/index.js":function(e,r,t){"use strict";var n=Object.getOwnPropertySymbols,o=Object.prototype.hasOwnProperty,i=Object.prototype.propertyIsEnumerable;function a(e){if(null==e)throw new TypeError("Object.assign cannot be called with null or undefined");return Object(e)}e.exports=function(){try{if(!Object.assign)return!1;var e=new String("abc");if(e[5]="de","5"===Object.getOwnPropertyNames(e)[0])return!1;for(var r={},t=0;t<10;t++)r["_"+String.fromCharCode(t)]=t;if("0123456789"!==Object.getOwnPropertyNames(r).map((function(e){return r[e]})).join(""))return!1;var n={};return"abcdefghijklmnopqrst".split("").forEach((function(e){n[e]=e})),"abcdefghijklmnopqrst"===Object.keys(Object.assign({},n)).join("")}catch(e){return!1}}()?Object.assign:function(e,r){for(var t,s,c=a(e),u=1;u<arguments.length;u++){for(var f in t=Object(arguments[u]))o.call(t,f)&&(c[f]=t[f]);if(n){s=n(t);for(var l=0;l<s.length;l++)i.call(t,s[l])&&(c[s[l]]=t[s[l]])}}return c}},"./node_modules/prop-types/checkPropTypes.js":function(e,r,t){"use strict";var n=function(){},o=t("./node_modules/prop-types/lib/ReactPropTypesSecret.js"),i={},a=Function.call.bind(Object.prototype.hasOwnProperty);function s(e,r,t,s,c){for(var u in e)if(a(e,u)){var f;try{if("function"!=typeof e[u]){var l=Error((s||"React class")+": "+t+" type `"+u+"` is invalid; it must be a function, usually from the `prop-types` package, but received `"+typeof e[u]+"`.");throw l.name="Invariant Violation",l}f=e[u](r,u,s,t,null,o)}catch(e){f=e}if(!f||f instanceof Error||n((s||"React class")+": type specification of "+t+" `"+u+"` is invalid; the type checker function must return `null` or an `Error` but returned a "+typeof f+". You may have forgotten to pass an argument to the type checker creator (arrayOf, instanceOf, objectOf, oneOf, oneOfType, and shape all require an argument)."),f instanceof Error&&!(f.message in i)){i[f.message]=!0;var p=c?c():"";n("Failed "+t+" type: "+f.message+(null!=p?p:""))}}}n=function(e){var r="Warning: "+e;"undefined"!=typeof console&&console.error(r);try{throw new Error(r)}catch(e){}},s.resetWarningCache=function(){i={}},e.exports=s},"./node_modules/prop-types/factoryWithTypeCheckers.js":function(e,r,t){"use strict";var n=t("./node_modules/react-is/index.js"),o=t("./node_modules/object-assign/index.js"),i=t("./node_modules/prop-types/lib/ReactPropTypesSecret.js"),a=t("./node_modules/prop-types/checkPropTypes.js"),s=Function.call.bind(Object.prototype.hasOwnProperty),c=function(){};function u(){return null}c=function(e){var r="Warning: "+e;"undefined"!=typeof console&&console.error(r);try{throw new Error(r)}catch(e){}},e.exports=function(e,r){var t="function"==typeof Symbol&&Symbol.iterator;var f={array:y("array"),bool:y("boolean"),func:y("function"),number:y("number"),object:y("object"),string:y("string"),symbol:y("symbol"),any:d(u),arrayOf:function(e){return d((function(r,t,n,o,a){if("function"!=typeof e)return new p("Property `"+a+"` of component `"+n+"` has invalid PropType notation inside arrayOf.");var s=r[t];if(!Array.isArray(s))return new p("Invalid "+o+" `"+a+"` of type `"+b(s)+"` supplied to `"+n+"`, expected an array.");for(var c=0;c<s.length;c++){var u=e(s,c,n,o,a+"["+c+"]",i);if(u instanceof Error)return u}return null}))},element:d((function(r,t,n,o,i){var a=r[t];return e(a)?null:new p("Invalid "+o+" `"+i+"` of type `"+b(a)+"` supplied to `"+n+"`, expected a single ReactElement.")})),elementType:d((function(e,r,t,o,i){var a=e[r];return n.isValidElementType(a)?null:new p("Invalid "+o+" `"+i+"` of type `"+b(a)+"` supplied to `"+t+"`, expected a single ReactElement type.")})),instanceOf:function(e){return d((function(r,t,n,o,i){if(!(r[t]instanceof e)){var a=e.name||"<<anonymous>>";return new p("Invalid "+o+" `"+i+"` of type `"+function(e){if(!e.constructor||!e.constructor.name)return"<<anonymous>>";return e.constructor.name}(r[t])+"` supplied to `"+n+"`, expected instance of `"+a+"`.")}return null}))},node:d((function(e,r,t,n,o){return m(e[r])?null:new p("Invalid "+n+" `"+o+"` supplied to `"+t+"`, expected a ReactNode.")})),objectOf:function(e){return d((function(r,t,n,o,a){if("function"!=typeof e)return new p("Property `"+a+"` of component `"+n+"` has invalid PropType notation inside objectOf.");var c=r[t],u=b(c);if("object"!==u)return new p("Invalid "+o+" `"+a+"` of type `"+u+"` supplied to `"+n+"`, expected an object.");for(var f in c)if(s(c,f)){var l=e(c,f,n,o,a+"."+f,i);if(l instanceof Error)return l}return null}))},oneOf:function(e){if(!Array.isArray(e))return arguments.length>1?c("Invalid arguments supplied to oneOf, expected an array, got "+arguments.length+" arguments. A common mistake is to write oneOf(x, y, z) instead of oneOf([x, y, z])."):c("Invalid argument supplied to oneOf, expected an array."),u;function r(r,t,n,o,i){for(var a=r[t],s=0;s<e.length;s++)if(l(a,e[s]))return null;var c=JSON.stringify(e,(function(e,r){return"symbol"===v(r)?String(r):r}));return new p("Invalid "+o+" `"+i+"` of value `"+String(a)+"` supplied to `"+n+"`, expected one of "+c+".")}return d(r)},oneOfType:function(e){if(!Array.isArray(e))return c("Invalid argument supplied to oneOfType, expected an instance of array."),u;for(var r=0;r<e.length;r++){var t=e[r];if("function"!=typeof t)return c("Invalid argument supplied to oneOfType. Expected an array of check functions, but received "+h(t)+" at index "+r+"."),u}return d((function(r,t,n,o,a){for(var s=0;s<e.length;s++){if(null==(0,e[s])(r,t,n,o,a,i))return null}return new p("Invalid "+o+" `"+a+"` supplied to `"+n+"`.")}))},shape:function(e){return d((function(r,t,n,o,a){var s=r[t],c=b(s);if("object"!==c)return new p("Invalid "+o+" `"+a+"` of type `"+c+"` supplied to `"+n+"`, expected `object`.");for(var u in e){var f=e[u];if(f){var l=f(s,u,n,o,a+"."+u,i);if(l)return l}}return null}))},exact:function(e){return d((function(r,t,n,a,s){var c=r[t],u=b(c);if("object"!==u)return new p("Invalid "+a+" `"+s+"` of type `"+u+"` supplied to `"+n+"`, expected `object`.");var f=o({},r[t],e);for(var l in f){var d=e[l];if(!d)return new p("Invalid "+a+" `"+s+"` key `"+l+"` supplied to `"+n+"`.\nBad object: "+JSON.stringify(r[t],null,"  ")+"\nValid keys: "+JSON.stringify(Object.keys(e),null,"  "));var y=d(c,l,n,a,s+"."+l,i);if(y)return y}return null}))}};function l(e,r){return e===r?0!==e||1/e==1/r:e!=e&&r!=r}function p(e){this.message=e,this.stack=""}function d(e){var t={},n=0;function o(o,a,s,u,f,l,d){if(u=u||"<<anonymous>>",l=l||s,d!==i){if(r){var y=new Error("Calling PropTypes validators directly is not supported by the `prop-types` package. Use `PropTypes.checkPropTypes()` to call them. Read more at http://fb.me/use-check-prop-types");throw y.name="Invariant Violation",y}if("undefined"!=typeof console){var m=u+":"+s;!t[m]&&n<3&&(c("You are manually calling a React.PropTypes validation function for the `"+l+"` prop on `"+u+"`. This is deprecated and will throw in the standalone `prop-types` package. You may be seeing this warning due to a third-party PropTypes library. See https://fb.me/react-warning-dont-call-proptypes for details."),t[m]=!0,n++)}}return null==a[s]?o?null===a[s]?new p("The "+f+" `"+l+"` is marked as required in `"+u+"`, but its value is `null`."):new p("The "+f+" `"+l+"` is marked as required in `"+u+"`, but its value is `undefined`."):null:e(a,s,u,f,l)}var a=o.bind(null,!1);return a.isRequired=o.bind(null,!0),a}function y(e){return d((function(r,t,n,o,i,a){var s=r[t];return b(s)!==e?new p("Invalid "+o+" `"+i+"` of type `"+v(s)+"` supplied to `"+n+"`, expected `"+e+"`."):null}))}function m(r){switch(typeof r){case"number":case"string":case"undefined":return!0;case"boolean":return!r;case"object":if(Array.isArray(r))return r.every(m);if(null===r||e(r))return!0;var n=function(e){var r=e&&(t&&e[t]||e["@@iterator"]);if("function"==typeof r)return r}(r);if(!n)return!1;var o,i=n.call(r);if(n!==r.entries){for(;!(o=i.next()).done;)if(!m(o.value))return!1}else for(;!(o=i.next()).done;){var a=o.value;if(a&&!m(a[1]))return!1}return!0;default:return!1}}function b(e){var r=typeof e;return Array.isArray(e)?"array":e instanceof RegExp?"object":function(e,r){return"symbol"===e||!!r&&("Symbol"===r["@@toStringTag"]||"function"==typeof Symbol&&r instanceof Symbol)}(r,e)?"symbol":r}function v(e){if(null==e)return""+e;var r=b(e);if("object"===r){if(e instanceof Date)return"date";if(e instanceof RegExp)return"regexp"}return r}function h(e){var r=v(e);switch(r){case"array":case"object":return"an "+r;case"boolean":case"date":case"regexp":return"a "+r;default:return r}}return p.prototype=Error.prototype,f.checkPropTypes=a,f.resetWarningCache=a.resetWarningCache,f.PropTypes=f,f}},"./node_modules/prop-types/index.js":function(e,r,t){var n=t("./node_modules/react-is/index.js");e.exports=t("./node_modules/prop-types/factoryWithTypeCheckers.js")(n.isElement,!0)},"./node_modules/prop-types/lib/ReactPropTypesSecret.js":function(e,r,t){"use strict";e.exports="SECRET_DO_NOT_PASS_THIS_OR_YOU_WILL_BE_FIRED"},"./node_modules/react-is/cjs/react-is.development.js":function(e,r,t){"use strict";(function(){var e="function"==typeof Symbol&&Symbol.for,t=e?Symbol.for("react.element"):60103,n=e?Symbol.for("react.portal"):60106,o=e?Symbol.for("react.fragment"):60107,i=e?Symbol.for("react.strict_mode"):60108,a=e?Symbol.for("react.profiler"):60114,s=e?Symbol.for("react.provider"):60109,c=e?Symbol.for("react.context"):60110,u=e?Symbol.for("react.async_mode"):60111,f=e?Symbol.for("react.concurrent_mode"):60111,l=e?Symbol.for("react.forward_ref"):60112,p=e?Symbol.for("react.suspense"):60113,d=e?Symbol.for("react.suspense_list"):60120,y=e?Symbol.for("react.memo"):60115,m=e?Symbol.for("react.lazy"):60116,b=e?Symbol.for("react.block"):60121,v=e?Symbol.for("react.fundamental"):60117,h=e?Symbol.for("react.responder"):60118,j=e?Symbol.for("react.scope"):60119;function g(e){if("object"==typeof e&&null!==e){var r=e.$$typeof;switch(r){case t:var d=e.type;switch(d){case u:case f:case o:case a:case i:case p:return d;default:var b=d&&d.$$typeof;switch(b){case c:case l:case m:case y:case s:return b;default:return r}}case n:return r}}}var w=u,O=f,x=c,S=s,_=t,P=l,T=o,E=m,k=y,I=n,$=a,R=i,C=p,A=!1;function M(e){return g(e)===f}r.AsyncMode=w,r.ConcurrentMode=O,r.ContextConsumer=x,r.ContextProvider=S,r.Element=_,r.ForwardRef=P,r.Fragment=T,r.Lazy=E,r.Memo=k,r.Portal=I,r.Profiler=$,r.StrictMode=R,r.Suspense=C,r.isAsyncMode=function(e){return A||(A=!0,console.warn("The ReactIs.isAsyncMode() alias has been deprecated, and will be removed in React 17+. Update your code to use ReactIs.isConcurrentMode() instead. It has the exact same API.")),M(e)||g(e)===u},r.isConcurrentMode=M,r.isContextConsumer=function(e){return g(e)===c},r.isContextProvider=function(e){return g(e)===s},r.isElement=function(e){return"object"==typeof e&&null!==e&&e.$$typeof===t},r.isForwardRef=function(e){return g(e)===l},r.isFragment=function(e){return g(e)===o},r.isLazy=function(e){return g(e)===m},r.isMemo=function(e){return g(e)===y},r.isPortal=function(e){return g(e)===n},r.isProfiler=function(e){return g(e)===a},r.isStrictMode=function(e){return g(e)===i},r.isSuspense=function(e){return g(e)===p},r.isValidElementType=function(e){return"string"==typeof e||"function"==typeof e||e===o||e===f||e===a||e===i||e===p||e===d||"object"==typeof e&&null!==e&&(e.$$typeof===m||e.$$typeof===y||e.$$typeof===s||e.$$typeof===c||e.$$typeof===l||e.$$typeof===v||e.$$typeof===h||e.$$typeof===j||e.$$typeof===b)},r.typeOf=g})()},"./node_modules/react-is/index.js":function(e,r,t){"use strict";e.exports=t("./node_modules/react-is/cjs/react-is.development.js")},"./src/edit.js":function(e,r,t){"use strict";t.r(r),t.d(r,"default",(function(){return s}));var n=t("@wordpress/element"),o=t("./node_modules/prop-types/index.js"),i=t.n(o),a=t("@wordpress/i18n");function s(e){var r=e.className;return Object(n.createElement)("p",{className:r},Object(a.__)("Wholesome Examples – hello from the editor!","wholesomecode"))}s.propTypes={className:i.a.string.isRequired}},"./src/index.js":function(e,r,t){"use strict";t.r(r);var n=t("@wordpress/blocks"),o=t("@wordpress/i18n"),i=t("./src/edit.js"),a=t("./src/save.js");Object(n.registerBlockType)("wholesomecode/wholesome-examples",{title:Object(o.__)("Wholesome Examples","wholesomecode"),description:Object(o.__)("Best Practice WordPress Examples.","wholesomecode"),category:"common",icon:"smiley",supports:{html:!1},edit:i.default,save:a.default})},"./src/save.js":function(e,r,t){"use strict";t.r(r),t.d(r,"default",(function(){return i}));var n=t("@wordpress/element"),o=t("@wordpress/i18n");function i(){return Object(n.createElement)("p",null,Object(o.__)("Wholesome Examples – hello from the saved content!","wholesomecode"))}},"@wordpress/blocks":function(e,r){!function(){e.exports=this.wp.blocks}()},"@wordpress/element":function(e,r){!function(){e.exports=this.wp.element}()},"@wordpress/i18n":function(e,r){!function(){e.exports=this.wp.i18n}()}});
//# sourceMappingURL=index.js.map