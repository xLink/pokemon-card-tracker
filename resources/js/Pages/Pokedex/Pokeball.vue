<template>
  <svg 
    xmlns="http://www.w3.org/2000/svg" 
    xmlns:xlink="http://www.w3.org/1999/xlink" 
    version="1.1" 
    x="0px" 
    y="0px" 
    viewBox="0 0 100 125" 
    :style="`transform: rotate(${rotation}) scale(${scale}); opacity: ${opacity}`" 
    xml:space="preserve"
  >
    <g>
      <path d="M6,50 a44,44 0 0,1 88,0" :fill="topColor" />
      <path d="M6,50 a44,44 0 0,0 88,0" :fill="bottomColor" />
      <circle 
        ref="outer circle"
        style="" 
        cx="50" 
        cy="50" 
        r="44.667" 
        fill="none" 
        :stroke="border" 
        :stroke-width="borderSize" 
        stroke-linecap="round" 
        stroke-linejoin="round" 
        stroke-miterlimit="10"
      />
      <circle 
        ref="inner circle"
        style="" 
        cx="50" 
        cy="50" 
        r="12.023" 
        fill="#ffffff" 
        :stroke="border" 
        :stroke-width="borderSize" 
        stroke-linecap="round" 
        stroke-linejoin="round" 
        stroke-miterlimit="10"
      />
      <circle 
        ref="inner inner circle"
        style="" 
        cx="50" 
        cy="50" 
        r="8" 
        fill="#ededed" 
        :stroke="border" 
        :stroke-width="1" 
        stroke-linecap="round" 
        stroke-linejoin="round" 
        stroke-miterlimit="10"
      />
      <line 
        style="" 
        x1="5.333" 
        y1="50" 
        x2="37.977" 
        y2="50" 
        fill="none" 
        :stroke="border" 
        :stroke-width="borderSize" 
        stroke-linecap="round" 
        stroke-linejoin="round" 
        stroke-miterlimit="10"
      />
      <line 
        style="" 
        x1="62.023" 
        y1="50" 
        x2="94.667" 
        y2="50" 
        fill="none" 
        :stroke="border" 
        :stroke-width="borderSize" 
        stroke-linecap="round" 
        stroke-linejoin="round" 
        stroke-miterlimit="10"
      />
    </g>
  </svg>
</template>

<script>

export default {
  name: 'Pokeball',
  props: {
    topColor: {
      type: String,
      default: '#f00'
    },
    bottomColor: {
      type: String,
      default: '#000'
    },
    border: {
      type: String,
      default: '#000'
    },
    borderSize: {
      type: String,
      default: '2'
    },
    scale: {
      type: String,
      default: '100%'
    },
    rotation: {
      type: String,
      default: '0deg'
    },
    opacity: {
      type: String,
      default: '1'
    }
  }
};
</script>