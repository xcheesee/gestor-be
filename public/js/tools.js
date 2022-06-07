function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}

function downloadXLS(filename){
	//var datapesquisa = document.getElementById(dataPesquisaInicial);
    var tableID = "printableTable"
	var tabelarel = document.getElementById(tableID);
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();
    var ho = String(today.getHours()).padStart(2, '0');
    var mi = String(today.getMinutes()).padStart(2, '0');
    var se = String(today.getSeconds()).padStart(2, '0');

    // Bootstrap configuration classes ["base", "theme", "container"].
    TableExport.prototype.bootstrap = ["btn", "btn-default", "btn-toolbar"];
	//TableExport.prototype.xlsx.buttonContent = 'My Content';
	var table = new TableExport(tabelarel,{
		//filename: "Visitas_"+datapesquisa.value.replaceAll('/', '-'),
		filename: filename+"_"+dd+mm+yyyy+ho+mi+se,
		bootstrap: true,
		exportButtons: false,
        formats: ["xlsx"],
		sheetname: "visitas"
    });

	var XLSX = table.CONSTANTS.FORMAT.XLSX;
	var XLS = table.CONSTANTS.FORMAT.XLS;
	var CSV = table.CONSTANTS.FORMAT.CSV;
	var exportData = table.getExportData();
	var xlsxData = exportData[tableID][XLSX];
	var XLSbutton = document.getElementById('customXLSButton');

	XLSbutton.addEventListener('click', function (e) {
		table.export2file(xlsxData.data, xlsxData.mimeType, xlsxData.filename, xlsxData.fileExtension, xlsxData.merges, xlsxData.RTL, xlsxData.sheetname);
	});

}

function dataParaDate(valor){
    var arrData = valor.split('/');

    var stringFormatada = arrData[1] + '-' + arrData[0] + '-' + arrData[2];
    var dataFormatada = new Date(stringFormatada);
    return dataFormatada;
}
