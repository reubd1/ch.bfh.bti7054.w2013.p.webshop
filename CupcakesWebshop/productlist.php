<style type="text/css">
 
.product div {
  margin: 20px;
}
 
.product ul {
  list-style-type: none;
  width: 550px;
}
 
.product h3 {
  font: bold 20px/1.5 Helvetica, Verdana, sans-serif;
}
 
.product li img {
  float: left;
  margin: 0 15px 0 0;
}
 
.product li p {
  font: 200 12px/1.5 Georgia, Times New Roman, serif;
}
 
.product li {
  padding: 10px;
  overflow: auto;
}
 
.product li:hover {
  background: #eee;
  cursor: pointer;
}
</style>
<div class="product">
  <ul>
    <?php content(); ?>
  </ul>
</div>
