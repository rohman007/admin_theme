<?php

global $custom_path;

if($custom_path == 'game') { ?>
<style type="text/css">
.report-modal {
  display: none;
  position: fixed;
  z-index: 20;
  padding-top: 100px;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgb(0,0,0);
  background-color: rgba(0,0,0,0.4);
}
.report-modal-content {
  background-color: #fefefe;
  color: #000;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  max-width: 320px;
}
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}
.close:hover,.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}
.report-label {
  padding: 0 10px;
  margin-right: 5px;
  border-radius: 15px;
  display: inline-block;
  margin-bottom: 8px;
}
</style>
<?php } ?>