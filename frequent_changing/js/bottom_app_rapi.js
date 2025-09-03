"use strict";
 let SanitizeInnerHtmlOpts;
 let loadTimeData;
function LoadTimeData(){}

(function() {
    'use strict';

    LoadTimeData.prototype = {
        /**
         * Sets the backing object.
         *
         * Note that there is no getter for |data_| to discourage abuse of the form:
         *
         *     let value = loadTimeData.data()['key'];
         *
         * @param {Object} value The de-serialized page data.
         */
        set data(value) {
            expect(!this.data_, 'Re-setting data.');
            this.data_ = value;
        },

        /**
         * Returns a JsEvalContext for |data_|.
         * @returns {JsEvalContext}
         */
        createJsEvalContext: function() {
            return new JsEvalContext(this.data_);
        },

        /**
         * @param {string} id An ID of a value that might exist.
         * @return {boolean} True if |id| is a key in the dictionary.
         */
        valueExists: function(id) {
            return id in this.data_;
        },

        /**
         * Fetches a value, expecting that it exists.
         * @param {string} id The key that identifies the desired value.
         * @return {*} The corresponding value.
         */
        getValue: function(id) {
            expect(this.data_, 'No data. Did you remember to include strings.js?');
            const value = this.data_[id];
            expect(typeof value != 'undefined', 'Could not find value for ' + id);
            return value;
        },

        /**
         * As above, but also makes sure that the value is a string.
         * @param {string} id The key that identifies the desired string.
         * @return {string} The corresponding string value.
         */
        getString: function(id) {
            const value = this.getValue(id);
            expectIsType(id, value, 'string');
            return /** @type {string} */ (value);
        },

        /**
         * Returns a formatted localized string where $1 to $9 are replaced by the
         * second to the tenth argument.
         * @param {string} id The ID of the string we want.
         * @param {...(string|number)} var_args The extra values to include in the
         *     formatted output.
         * @return {string} The formatted string.
         */
        getStringF: function(id, var_args) {
            const value = this.getString(id);
            if (!value) {
                return '';
            }

            const args = Array.prototype.slice.call(arguments);
            args[0] = value;
            return this.substituteString.apply(this, args);
        },

        /**
         * Make a string safe for use with with Polymer bindings that are
         * inner-h-t-m-l (or other innerHTML use).
         * @param {string} rawString The unsanitized string.
         * @param {SanitizeInnerHtmlOpts=} opts Optional additional allowed tags and
         *     attributes.
         * @return {string}
         */
        sanitizeInnerHtml: function(rawString, opts) {
            opts = opts || {};
            return parseHtmlSubset('<b>' + rawString + '</b>', opts.tags, opts.attrs)
                .firstChild.innerHTML;
        },

        /**
         * Returns a formatted localized string where $1 to $9 are replaced by the
         * second to the tenth argument. Any standalone $ signs must be escaped as
         * $$.
         * @param {string} label The label to substitute through.
         *     This is not an resource ID.
         * @param {...(string|number)} var_args The extra values to include in the
         *     formatted output.
         * @return {string} The formatted string.
         */
        substituteString: function(label, var_args) {
            const varArgs = arguments;
            return label.replace(/\$(.|$|\n)/g, function(m) {
                assert(m.match(/\$[$1-9]/), 'Unescaped $ found in localized string.');
                return m == '$$' ? '$' : varArgs[m[1]];
            });
        },

        /**
         * Returns a formatted string where $1 to $9 are replaced by the second to
         * tenth argument, split apart into a list of pieces describing how the
         * substitution was performed. Any standalone $ signs must be escaped as $$.
         * @param {string} label A localized string to substitute through.
         *     This is not an resource ID.
         * @param {...(string|number)} var_args The extra values to include in the
         *     formatted output.
         * @return {!Array<!{value: string, arg: (null|string)}>} The formatted
         *     string pieces.
         */
        getSubstitutedStringPieces: function(label, var_args) {
            const varArgs = arguments;
            // Split the string by separately matching all occurrences of $1-9 and of
            // non $1-9 pieces.
            const pieces = (label.match(/(\$[1-9])|(([^$]|\$([^1-9]|$))+)/g) ||
                []).map(function(p) {
                // Pieces that are not $1-9 should be returned after replacing $$
                // with $.
                if (!p.match(/^\$[1-9]$/)) {
                    assert(
                        (p.match(/\$/g) || []).length % 2 == 0,
                        'Unescaped $ found in localized string.');
                    return {value: p.replace(/\$\$/g, '$'), arg: null};
                }

                // Otherwise, return the substitution value.
                return {value: varArgs[p[1]], arg: p};
            });

            return pieces;
        },

        /**
         * As above, but also makes sure that the value is a boolean.
         * @param {string} id The key that identifies the desired boolean.
         * @return {boolean} The corresponding boolean value.
         */
        getBoolean: function(id) {
            const value = this.getValue(id);
            expectIsType(id, value, 'boolean');
            return /** @type {boolean} */ (value);
        },

        /**
         * As above, but also makes sure that the value is an integer.
         * @param {string} id The key that identifies the desired number.
         * @return {number} The corresponding number value.
         */
        getInteger: function(id) {
            const value = this.getValue(id);
            expectIsType(id, value, 'number');
            expect(value == Math.floor(value), 'Number isn\'t integer: ' + value);
            return /** @type {number} */ (value);
        },

        /**
         * Override values in loadTimeData with the values found in |replacements|.
         * @param {Object} replacements The dictionary object of keys to replace.
         */
        overrideValues: function(replacements) {
            expect(
                typeof replacements == 'object',
                'Replacements must be a dictionary object.');
            for (const key in replacements) {
                this.data_[key] = replacements[key];
            }
        }
    };

    /**
     * Checks condition, displays error message if expectation fails.
     * @param {*} condition The condition to check for truthiness.
     * @param {string} message The message to display if the check fails.
     */
    function expect(condition, message) {
        if (!condition) {
            console.error(
                'Unexpected condition on ' + document.location.href + ': ' + message);
        }
    }

    /**
     * Checks that the given value has the given type.
     * @param {string} id The id of the value (only used for error message).
     * @param {*} value The value to check the type on.
     * @param {string} type The type we expect |value| to be.
     */
    function expectIsType(id, value, type) {
        expect(
            typeof value == type, '[' + value + '] (' + id + ') is not a ' + type);
    }

    expect(!loadTimeData, 'should only include this file once');
    loadTimeData = new LoadTimeData;

    // Expose |loadTimeData| directly on |window|. This is only necessary by the
    // auto-generated load_time_data.m.js, since within a JS module the scope is
    // local.
    window.loadTimeData = loadTimeData;
})();
loadTimeData.data = {"details":"Details","errorCode":"HTTP ERROR 500","fontfamily":"'Segoe UI', Tahoma, sans-serif","fontsize":"75%","heading":{"hostName":"localhost","msg":"This page isn’t working"},"hideDetails":"Hide details","iconClass":"icon-generic","language":"en","suggestionsDetails":[],"suggestionsSummaryList":[],"summary":{"failedUrl":"http://localhost/biponi/Authentication/loginCheck","hostName":"localhost","msg":"\u003Cstrong jscontent=\"hostName\">\u003C/strong> is currently unable to handle this request."},"textdirection":"ltr","title":"localhost"};


// branding (c) 2012 The Chromium Authors. All rights reserved.
    // Use of this source code is governed by a BSD-style license that can be
    // found in the LICENSE file.

    // This file serves as a proxy to bring the included js file from /third_party
    // into its correct location under the resources directory tree, whence it is
    // delivered via a chrome://resources URL.  See ../webui_resources.grd.

    // Note: this <include> is not behind a single-line comment because the first
    // line of the file is source code (so the first line would be skipped) instead
    // of a licence header.
    // clang-format off
    (function(){let i=null;function k(){return Function.prototype.call.apply(Array.prototype.slice,arguments)}function l(a,b){let c=k(arguments,2);return function(){return b.apply(a,c)}}function m(a,b){let c=new n(b);for(c.f=[a];c.f.length;){let e=c,d=c.f.shift();e.g(d);for(d=d.firstChild;d;d=d.nextSibling)d.nodeType==1&&e.f.push(d)}}function n(a){this.g=a}function o(a){a.style.display=""}function p(a){a.style.display="none"};let q=":",r=/\s*;\s*/;function s(){this.i.apply(this,arguments)}s.prototype.i=function(a,b){if(!this.a)this.a={};if(b){let c=this.a,e=b.a,d;for(d in e)c[d]=e[d]}else for(c in d=this.a,e=t,e)d[c]=e[c];this.a.$this=a;this.a.$context=this;this.d=typeof a!="undefined"&&a!=i?a:"";if(!b)this.a.$top=this.d};let t={$default:i},u=[];function v(a){for(let b in a.a)delete a.a[b];a.d=i;u.push(a)}function w(a,b,c){try{return b.call(c,a.a,a.d)}catch(e){return t.$default}}
        function x(a,b,c,e){if(u.length>0){let d=u.pop();s.call(d,b,a);a=d}else a=new s(b,a);a.a.$index=c;a.a.$count=e;return a}let y="a_",z="b_",A="with (a_) with (b_) return ",D={};function E(a){if(!D[a])try{D[a]=new Function(y,z,A+a)}catch(b){}return D[a]}function F(a){for(let b=[],a=a.split(r),c=0,e=a.length;c<e;++c){let d=a[c].indexOf(q);if(!(d<0)){let f;f=a[c].substr(0,d).replace(/^\s+/,"").replace(/\s+$/,"");d=E(a[c].substr(d+1));b.push(f,d)}}return b};let G="jsinstance",H="jsts",I="*",J="div",K="id";function L(){}let M=0,N={0:{}},P={},Q={},R=[];function S(a){a.__jstcache||m(a,function(a){T(a)})}let U=[["jsselect",E],["jsdisplay",E],["jsvalues",F],["jsvars",F],["jseval",function(a){for(let b=[],a=a.split(r),c=0,e=a.length;c<e;++c)if(a[c]){let d=E(a[c]);b.push(d)}return b}],["transclude",function(a){return a}],["jscontent",E],["jsskip",E]];
        function T(a){if(a.__jstcache)return a.__jstcache;let b=a.getAttribute("jstcache");if(b!=i)return a.__jstcache=N[b];for(let b=R.length=0,c=U.length;b<c;++b){let e=U[b][0],d=a.getAttribute(e);Q[e]=d;d!=i&&R.push(e+"="+d)}if(R.length==0)return a.setAttribute("jstcache","0"),a.__jstcache=N[0];let f=R.join("&");if(b=P[f])return a.setAttribute("jstcache",b),a.__jstcache=N[b];for(let h={},b=0,c=U.length;b<c;++b){let d=U[b],e=d[0],g=d[1],d=Q[e];d!=i&&(h[e]=g(d))}b=""+ ++M;a.setAttribute("jstcache",b);N[b]=
            h;P[f]=b;return a.__jstcache=h}function V(a,b){a.h.push(b);a.k.push(0)}function W(a){return a.c.length?a.c.pop():[]}
        L.prototype.e=function(a,b){let c=X(b),e=c.transclude;if(e)(c=Y(e))?(b.parentNode.replaceChild(c,b),e=W(this),e.push(this.e,a,c),V(this,e)):b.parentNode.removeChild(b);else if(c=c.jsselect){let c=w(a,c,b),d=b.getAttribute(G),f=!1;d&&(d.charAt(0)==I?(d=parseInt(d.substr(1),10),f=!0):d=parseInt(d,10));let h=c!=i&&typeof c=="object"&&typeof c.length=="number",e=h?c.length:1,g=h&&e==0;if(h)if(g)d?b.parentNode.removeChild(b):(b.setAttribute(G,"*0"),p(b));else if(o(b),d===i||d===""||f&&d<e-1){f=W(this);
            d=d||0;for(h=e-1;d<h;++d){let j=b.cloneNode(!0);b.parentNode.insertBefore(j,b);Z(j,c,d);g=x(a,c[d],d,e);f.push(this.b,g,j,v,g,i)}Z(b,c,d);g=x(a,c[d],d,e);f.push(this.b,g,b,v,g,i);V(this,f)}else d<e?(f=c[d],Z(b,c,d),g=x(a,f,d,e),f=W(this),f.push(this.b,g,b,v,g,i),V(this,f)):b.parentNode.removeChild(b);else c==i?p(b):(o(b),g=x(a,c,0,1),f=W(this),f.push(this.b,g,b,v,g,i),V(this,f))}else this.b(a,b)};
        L.prototype.b=function(a,b){let c=X(b),e=c.jsdisplay;if(e){if(!w(a,e,b)){p(b);return}o(b)}if(e=c.jsvars)for(let d=0,f=e.length;d<f;d+=2){let h=e[d],g=w(a,e[d+1],b);a.a[h]=g}if(e=c.jsvalues){d=0;for(f=e.length;d<f;d+=2)if(g=e[d],h=w(a,e[d+1],b),g.charAt(0)=="$")a.a[g]=h;else if(g.charAt(0)=="."){for(let g=g.substr(1).split("."),j=b,O=g.length,B=0,$=O-1;B<$;++B){let C=g[B];j[C]||(j[C]={});j=j[C]}j[g[O-1]]=h}else g&&(typeof h=="boolean"?h?b.setAttribute(g,g):b.removeAttribute(g):b.setAttribute(g,""+
            h))}if(e=c.jseval){d=0;for(f=e.length;d<f;++d)w(a,e[d],b)}e=c.jsskip;if(!e||!w(a,e,b))if(c=c.jscontent){if(c=""+w(a,c,b),b.innerHTML!=c){for(;b.firstChild;)e=b.firstChild,e.parentNode.removeChild(e);b.appendChild(this.j.createTextNode(c))}}else{c=W(this);for(e=b.firstChild;e;e=e.nextSibling)e.nodeType==1&&c.push(this.e,a,e);c.length&&V(this,c)}};function X(a){if(a.__jstcache)return a.__jstcache;let b=a.getAttribute("jstcache");if(b)return a.__jstcache=N[b];return T(a)}
        function Y(a,b){let c=document;if(b){let e=c.getElementById(a);if(!e){let e=b(),d=H,f=c.getElementById(d);if(!f)f=c.createElement(J),f.id=d,p(f),f.style.position="absolute",c.body.appendChild(f);d=c.createElement(J);f.appendChild(d);d.innerHTML=e;e=c.getElementById(a)}c=e}else c=c.getElementById(a);return c?(S(c),c=c.cloneNode(!0),c.removeAttribute(K),c):i}function Z(a,b,c){c==b.length-1?a.setAttribute(G,I+c):a.setAttribute(G,""+c)};window.jstGetTemplate=Y;window.JsEvalContext=s;window.jstProcess=function(a,b){let c=new L;S(b);c.j=b?b.nodeType==9?b:b.ownerDocument||document:document;let e=l(c,c.e,a,b),d=c.h=[],f=c.k=[];c.c=[];e();for(let h,g,j;d.length;)h=d[d.length-1],e=f[f.length-1],e>=h.length?(e=c,g=d.pop(),g.length=0,e.c.push(g),f.pop()):(g=h[e++],j=h[e++],h=h[e++],f[f.length-1]=e,g.call(c,j,h))};
    })()

    let tp = document.getElementById('t');jstProcess(loadTimeData.createJsEvalContext(), tp);
