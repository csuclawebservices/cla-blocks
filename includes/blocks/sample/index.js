(()=>{"use strict";var e,n={900:()=>{const e=window.wp.blocks,n=window.wp.i18n,o=window.wp.blockEditor,r=window.ReactJSXRuntime,s=JSON.parse('{"UU":"cla-blocks/sample"}');(0,e.registerBlockType)(s.UU,{edit:function(e){const{attributes:s,setAttributes:t}=e;return(0,r.jsxs)("div",{...(0,o.useBlockProps)(),children:[(0,r.jsx)("p",{children:(0,n.__)("Cla Blocks – hello from the editor!","cla-blocks")}),(0,r.jsx)("h2",{children:"Multi Inner Blocks"}),(0,r.jsxs)("div",{className:"first-section",children:[(0,r.jsx)("h3",{children:"First Section"}),(0,r.jsx)(o.InnerBlocks,{allowedBlocks:["core/paragraph","core/image"],value:s.firstSectionContent,onChange:e=>t({firstSectionContent:e}),template:[["core/paragraph",{}]]},"first")]}),(0,r.jsxs)("div",{className:"second-section",children:[(0,r.jsx)("h3",{children:"Second Section"}),(0,r.jsx)(o.InnerBlocks,{allowedBlocks:["core/paragraph","core/image"],value:s.secondSectionContent,onChange:e=>t({secondSectionContent:e}),template:[["core/paragraph",{}]]},"second")]})]})},save:function(){return(0,r.jsxs)(r.Fragment,{children:[(0,r.jsx)("div",{className:"first-section",children:(0,r.jsx)(o.InnerBlocks.Content,{})}),(0,r.jsx)("div",{className:"second-section",children:(0,r.jsx)(o.InnerBlocks.Content,{})})]})}})}},o={};function r(e){var s=o[e];if(void 0!==s)return s.exports;var t=o[e]={exports:{}};return n[e](t,t.exports,r),t.exports}r.m=n,e=[],r.O=(n,o,s,t)=>{if(!o){var c=1/0;for(d=0;d<e.length;d++){for(var[o,s,t]=e[d],i=!0,l=0;l<o.length;l++)(!1&t||c>=t)&&Object.keys(r.O).every((e=>r.O[e](o[l])))?o.splice(l--,1):(i=!1,t<c&&(c=t));if(i){e.splice(d--,1);var a=s();void 0!==a&&(n=a)}}return n}t=t||0;for(var d=e.length;d>0&&e[d-1][2]>t;d--)e[d]=e[d-1];e[d]=[o,s,t]},r.o=(e,n)=>Object.prototype.hasOwnProperty.call(e,n),(()=>{var e={740:0,420:0};r.O.j=n=>0===e[n];var n=(n,o)=>{var s,t,[c,i,l]=o,a=0;if(c.some((n=>0!==e[n]))){for(s in i)r.o(i,s)&&(r.m[s]=i[s]);if(l)var d=l(r)}for(n&&n(o);a<c.length;a++)t=c[a],r.o(e,t)&&e[t]&&e[t][0](),e[t]=0;return r.O(d)},o=globalThis.webpackChunkcla_blocks=globalThis.webpackChunkcla_blocks||[];o.forEach(n.bind(null,0)),o.push=n.bind(null,o.push.bind(o))})();var s=r.O(void 0,[420],(()=>r(900)));s=r.O(s)})();