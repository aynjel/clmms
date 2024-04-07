function PrintElem(elem) {
  var mywindow = window.open("", "PRINT", "height=400,width=600");

  mywindow.document.write("<html><head><title>" + document.title + "</title>");
  mywindow.document.write("</head><body>");
  mywindow.document.write(
    "<header style='display: flex; justify-content: space-between; align-items: center;'>"
  );
  mywindow.document.write(
    "<img src='https://upload.wikimedia.org/wikipedia/commons/thumb/9/9a/CTU_new_logo.png/1200px-CTU_new_logo.png' alt='CTU Logo' style='width: 100px; height: 100px;' />"
  );
  mywindow.document.write(
    "<p style='text-align: center;'>Republic of the Philippines <br />"
  );
  mywindow.document.write("CEBU TECHNOLOGICAL UNIVERSITY <br />");
  mywindow.document.write("TUBURAN CAMPUS <br />");
  mywindow.document.write(
    "Brgy. 8 Poblacion, Tuburan, Cebu, Philippines <br />"
  );
  mywindow.document.write(
    "Website: www.ctu.edu.ph | Email: tuburan.campus@ctu.edu.ph <br />"
  );
  mywindow.document.write("Phone: +6332 463 9313 | Loc: 1523</p>");
  mywindow.document.write(
    "<img src='https://upload.wikimedia.org/wikipedia/en/thumb/4/49/Seal_of_ASEAN.svg/1200px-Seal_of_ASEAN.svg.png' alt='ASEAN Logo' style='width: 100px; height: 100px;' />"
  );
  mywindow.document.write("</header>");
  mywindow.document.write(document.getElementById(elem).innerHTML);
  mywindow.document.write("</body></html>");

  mywindow.document.close(); // necessary for IE >= 10
  mywindow.focus(); // necessary for IE >= 10*/

  mywindow.print();
  mywindow.close();

  return true;
}
