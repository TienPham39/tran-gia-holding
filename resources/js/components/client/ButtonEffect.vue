<template>
  <!-- <button class="hover-effect font-mont uppercase cursor-pointer font-semibold text-white text-xl rounded-md flex items-center gap-2">
    <span></span>
    
    <slot></slot>

    <slot name="icon"></slot>

    <div class="bottom-left"></div>
    <div class="bottom-right"></div>
  </button> -->
  <div class="card cursor-pointer text-white font-semibold">
    <div class="card-bg"></div>
    <div class="content">
      <slot name="icon"></slot>
      <span class="label">
        <slot></slot>
      </span>
    </div>
  </div>
</template>

<script setup>
</script>

<style scoped>
@property --angle {
  syntax: "<angle>";
  initial-value: 0deg;
  inherits: false;
}
.content {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
}

.label {
  line-height: 1;
  color: #fff;
}

.card {
  position: relative;
  min-width: 220px;
  height: 44px;

  padding: 0 20px;
  border-radius: 10px;

  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;

  background: transparent;
  cursor: pointer;

  z-index: 0;
  overflow: visible;
  transition: transform 0.25s ease, box-shadow 0.25s ease;
  transform-origin: center;
}

.card-bg {
  position: absolute;
  inset: 2px; /* chừa viền gradient */
  border-radius: 8px;

  /* nền xám nhẹ */
  background: rgba(255, 255, 255, 0.12);

  /* blur nền phía sau */
  backdrop-filter: blur(6px);
  -webkit-backdrop-filter: blur(6px);

  z-index: -1;
}

.card:hover {
  transform: scale(1.05);
}

.card::before {
  content: '';
  position: absolute;
  inset: -3px;
  border-radius: inherit;
  padding: 3px;

  background: conic-gradient(
    from var(--angle),
    #4d080c,
    #e6e6e6,
    #4d080c,
    #e6e6e6,
    #4d080c
  );

  -webkit-mask:
    linear-gradient(#000 0 0) content-box,
    linear-gradient(#000 0 0);
  -webkit-mask-composite: xor;
  mask-composite: exclude;

  animation: none;
  z-index: -1;
}

.card::after {
  content: '';
  position: absolute;
  inset: -10px;
  border-radius: inherit;

  background: conic-gradient(
    from var(--angle),
    rgba(255,255,255,0.6),
    rgba(77,8,12,0.6),
    rgba(255,255,255,0.6),
    rgba(77,8,12,0.6),
    rgba(255,255,255,0.6)
  );

  filter: blur(30px);
  opacity: 0.5;
  animation: none;

  z-index: -2;
}

.card:hover::before,
.card:hover::after {
  animation: spin 6s linear infinite;
}

@keyframes spin {
  to {
    --angle: 360deg;
  }
}

/* .hover-effect {
  position: relative;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  background: rgba(255, 255, 255, 0.15);
  backdrop-filter: blur(1px);
  padding: 0.5rem 1.75rem;
}

.hover-effect span {
  position: absolute;
  inset: 0;
  pointer-events: none;
}

.hover-effect span::before,
.hover-effect span::after {
  content: "";
  position: absolute;
  width: 3px;
  height: 0%;
  background: #ffffff;
  transition: height 0.8s ease-in-out;
}

.hover-effect span::before {
  left: 0;
  bottom: 0;
}

.hover-effect span::after {
  right: 0;
  top: 0;
}

.hover-effect::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  height: 2px;
  width: 51%;
  background: linear-gradient(90deg, #ffffff, #4d080c);
  transform: scaleX(0);
  transform-origin: left;
  transition: transform 0.5s ease-in-out;
  transition-delay: 0.8s;
}

.hover-effect::after {
  content: "";
  position: absolute;
  top: 0;
  right: 0;
  height: 2px;
  width: 50%;
  background: linear-gradient(90deg, #4d080c, #ffffff);
  transform: scaleX(0);
  transform-origin: right;
  transition: transform 0.5s ease-in-out;
  transition-delay: 0.8s;
}

.hover-effect .bottom-left {
  position: absolute;
  bottom: 0;
  left: 0;
  height: 2px;
  width: 51%;
  background: linear-gradient(90deg, #ffffff, #4d080c);
  transform: scaleX(0);
  transform-origin: left;
  transition: transform 0.5s ease-in-out;
  transition-delay: 0.8s;
}

.hover-effect .bottom-right {
  position: absolute;
  bottom: 0;
  right: 0;
  height: 2px;
  width: 50%;
  background: linear-gradient(270deg, #ffffff, #4d080c);
  transform: scaleX(0);
  transform-origin: right;
  transition: transform 0.5s ease-in-out;
  transition-delay: 0.8s;
}

.hover-effect:hover span::before,
.hover-effect:hover span::after {
  height: 100%;
}

.hover-effect:hover::before,
.hover-effect:hover::after,
.hover-effect:hover .bottom-left,
.hover-effect:hover .bottom-right {
  transform: scaleX(1);
} */

/* @property --rotate{
  syntax: "<angle>";
  initial-value: 132deg;
  inherits: false;
}

:root{
  --card-height: 65vh;
  --card-width: calc(var(var(--card-height)/1.5));
}

body{
  min-height: 100vh;
  background: #4d080c;
  display: flex;
  align-items: center;
  flex-direction: column;
  padding-top: 2rem;
  padding-bottom: 2rem;
  box-sizing: border-box;
}

.card{
  background: #ffffff;
  width: var(--card-width);
  height: var(--card-height);
  padding: 3px;
  position: relative;
  border-radius: 6px;
  justify-content: center;
  align-items: center;
  text-align: center;
  display: flex;
  font-size: 1.5rem;
  color: rgb(88 199 250 / 0%);
  cursor: pointer
}

.card:hover{
  color: rgb(88 199 250 / 100%);
  transition: color 1s;
}

.card:hover::before, .card:hover:after {
  animation: none;
  opacity: 0;
}

.card::before{
  content: "";
  width: 104%;
  height: 102%;
  border-radius: 8px;
  background-image: linear-gradient(
    var(--rotate),
    #5ddcff, #3c67e3 43% #4e00c2
  );
  position: absolute;
  z-index: -1;
  top: -1%;
  left: -2%;
  animation: spin 2.5s linear infinite;
}

.card::after{
  position: absolute;
  content: "";
  top: calc(var(--card-height)/6);
  left: 0;
  right: 0;
  z-index: -1;
  height: 100%;
  width: 100%;
  margin: 0 auto;
  transform: scale(0.8);
  filter: blur(calc(var(--card-height)/6));
  background-image: linear-gradient(
    var(--rotate),
    #5ddcff, #3c67e3 43% #4e00c2
  );
  opacity: 1;
  transform: opacity 0.5s;
  animation: spin 2.5s linear infinite;
}

@keyframes spin {
  0%{
    --rotate: 0deg;
  }
  100%{
    --rotate: 360deg;
  }
}

a {
  color: #212534;
  text-decoration: none;
  font-family: sans-serif;
  font-weight: bold;
  margin-top: 2rem;
} */
</style>
