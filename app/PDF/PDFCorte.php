<?php

namespace App\PDF;

use App\Models\Cortes\Corte;
use App\Models\Proyecto;
use App\Facades\Context;
use Ghidev\Fpdf\Rotation;

class PDFCorte extends Rotation
{
    const TEMPLOGO = 'logo.png';

    /**
     * @var Corte
     */
    protected $corte;

    var $WidthTotal;
    var $txtTitleTam, $txtSubtitleTam, $txtSeccionTam, $txtContenidoTam, $txtFooterTam;
    var $encola = '';
    var $tipo, $num_items;
    var $totales = ['TOTAL', 0,0,0,0,0,0];

    /**
     * PDFCorte constructor.
     * @param string $orientation
     * @param array|string $unit
     * @param string $size
     * @param Corte $corte
     * @internal param array $data
     */
    public function __construct($orientation = 'P', $unit = 'cm', $size = 'A4', Corte $corte)
    {
        parent::__construct($orientation, $unit, $size);

        $this->SetAutoPageBreak(true, 1.5);
        $this->corte = $corte;
        $this->WidthTotal = $this->GetPageWidth() - 2;
        $this->txtTitleTam = 18;
        $this->txtSubtitleTam = 13;
        $this->txtSeccionTam = 9;
        $this->txtContenidoTam = 7;
        $this->txtFooterTam = 6;
    }

    /**
     *
     */
    function Header()
    {
        $this->title();
        $this->logo();

        //Obtener Posiciones despues de title y logo.
        $y_inicial = $this->getY();
        $x_inicial = $this->getX();

        $this->details();

        //Posiciones despues de details
        $y_final_1 = $this->getY();
        $this->setY($y_inicial);

        $alto1 = abs($y_final_1 - $y_inicial);

        //Round Detalis.
        $this->SetWidths(array(0.5 * $this->WidthTotal));
        $this->SetRounds(array('1234'));
        $this->SetRadius(array(0.2));
        $this->SetFills(array('255,255,255'));
        $this->SetTextColors(array('0,0,0'));
        $this->SetHeights(array($alto1));
        $this->SetStyles(array('DF'));
        $this->SetAligns("L");
        $this->SetFont('Arial', '', $this->txtContenidoTam);
        $this->setY($y_inicial);
        $this->Row(array(""));

        $this->setY($y_inicial);
        $this->setX($x_inicial);
        $this->details();

        //obtener Y despues de tabla de detalles
        $this->setY($y_final_1 );
        $this->Ln(0.5);

        if ($this->encola == 'modificados') {
            $this->encabezado_modificados();
            $this->SetRounds(array('', '', '', '', '', '', '', '', '', '', '', '', '', '', ''));
            $this->SetRadius(array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0));
            $this->SetFills(array('255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255'));
            $this->SetTextColors(array('0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0'));
            $this->SetHeights(array(0.35));
            $this->SetAligns(array('C', 'L', 'L', 'L', 'L', 'L','L', 'R', 'L', 'L', 'L', 'L', 'L', 'R', 'L'));
        }

        if ($this->encola == "no_modificados") {
            $this->encabezado_no_modificados();
            $this->SetRounds(array('', '', '', '', '', '', '', '', '', ''));
            $this->SetRadius(array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0));
            $this->SetFills(array('255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255'));
            $this->SetTextColors(array('0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0'));
            $this->SetHeights(array(0.35));
            $this->SetAligns(array('C', 'L', 'L', 'L', 'L', 'L','L', 'R', 'L', 'L'));
        }

        if ($this->encola == "totales") {
            $this->encabezado_totales();
            $this->SetRounds(array('', '', '', '', '', '', '',));
            $this->SetRadius(array(0, 0, 0, 0, 0, 0, 0));
            $this->SetFills(array('255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '180,180,180'));
            $this->SetTextColors(array('0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0'));
            $this->SetHeights(array(0.35));
            $this->SetAligns(array('L', 'R', 'R', 'R', 'R', 'R', 'R'));
        }

        if ($this->encola == "total") {
            $this->encabezado_totales();
            $this->SetRounds(array('', '', '', '', '', '', ''));
            $this->SetRadius(array(0, 0, 0, 0, 0, 0, 0));
            $this->SetFills(array('180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '0,0,0'));
            $this->SetTextColors(array('0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '255,255,255'));
            $this->SetHeights(array(0.35));
            $this->SetAligns(array('L', 'R', 'R', 'R', 'R', 'R', 'R'));
            $this->SetRounds(array('4', '', '', '', '', '', '3'));
            $this->SetRadius(array(0.2, 0, 0, 0, 0, 0, 0.2));
        }
    }

    private function title()
    {
        $this->SetFont('Arial', 'B', $this->txtTitleTam - 3);
        $this->CellFitScale(0.6 * $this->WidthTotal, 1.5, utf8_decode('CORTE DE CHECADOR'), 0, 1, 'L', 0);

        $this->Line(1, $this->GetY() + 0.2, $this->WidthTotal + 1, $this->GetY() + 0.2);
        $this->Ln(0.5);

        //Detalles (Titulo)
        $this->SetFont('Arial', 'B', $this->txtSeccionTam);
        $this->Cell(0.45 * $this->WidthTotal, 0.7, utf8_decode('Detalles'), 0, 1, 'L');
    }

    public function widths_items_modificados() {
        $this->SetWidths(array(
            0.035 * $this->WidthTotal,
            0.050 * $this->WidthTotal,
            0.065 * $this->WidthTotal,
            0.080 * $this->WidthTotal,
            0.075 * $this->WidthTotal,
            0.075 * $this->WidthTotal,
            0.075 * $this->WidthTotal,
            0.035 * $this->WidthTotal,
            0.085 * $this->WidthTotal,
            0.085 * $this->WidthTotal,
            0.075 * $this->WidthTotal,
            0.075 * $this->WidthTotal,
            0.075 * $this->WidthTotal,
            0.035 * $this->WidthTotal,
            0.080 * $this->WidthTotal
        ));
    }

    public function widths_items_no_modificados() {
        $this->SetWidths(array(
            0.03500 * $this->WidthTotal,
            0.08777 * $this->WidthTotal,
            0.10277 * $this->WidthTotal,
            0.11777 * $this->WidthTotal,
            0.11277 * $this->WidthTotal,
            0.11277 * $this->WidthTotal,
            0.11277 * $this->WidthTotal,
            0.07277 * $this->WidthTotal,
            0.12277 * $this->WidthTotal,
            0.12277 * $this->WidthTotal
        ));
    }

    public function widths_totales() {
        $this->SetWidths(array(
            0.1428 * $this->WidthTotal,
            0.1428 * $this->WidthTotal,
            0.1428 * $this->WidthTotal,
            0.1428 * $this->WidthTotal,
            0.1428 * $this->WidthTotal,
            0.1428 * $this->WidthTotal,
            0.1428 * $this->WidthTotal
        ));
    }

    private function logo()
    {
        if (Proyecto::find(Context::getId())->tiene_logo == 2) {
            $dataURI = "data:image/png;base64," . Proyecto::find(Context::getId())->logo;
            $dataPieces = explode(',', $dataURI);
            $encodedImg = $dataPieces[1];
            $decodedImg = base64_decode($encodedImg);


            //  Check if image was properly decoded
            if ($decodedImg !== false) {

                //  Save image to a temporary location
                if (file_put_contents(public_path('img/logo_temp.png'), $decodedImg) !== false) {

                    //  Open new PDF document and print image
                    //$this->image($dataURI, $this->WidthTotal - 1.3, 0.5, 2.33, 1.5);
                    $this->image(public_path('img/logo_temp.png'), $this->WidthTotal - 1.3, 0.5, 2.33, 1.5);
                    //dd("image");
                    //  Delete image from server
                    unlink(public_path('img/logo_temp.png'));
                }
            }
        } else {
            $this->image(public_path('img/logo_hc.png'), $this->WidthTotal - 1.3, 0.5, 2.33, 1.5);
        }
    }

    private function details()
    {
        $this->SetFont('Arial', 'B', $this->txtContenidoTam);
        $this->Cell(0.2 * $this->WidthTotal, 0.45, utf8_decode('PROYECTO:'), '', 0, 'L');
        $this->SetFont('Arial', '', $this->txtContenidoTam);
        $this->CellFitScale(0.3 * $this->WidthTotal, 0.5, utf8_decode(Proyecto::find(Context::getId())->descripcion), '', 1, 'L');

        $this->SetFont('Arial', 'B', $this->txtContenidoTam);
        $this->Cell(0.2 * $this->WidthTotal, 0.45, utf8_decode('CHECADOR:'), '', 0, 'LB');
        $this->SetFont('Arial', '', $this->txtContenidoTam);
        $this->CellFitScale(0.3 * $this->WidthTotal, 0.5, utf8_decode($this->corte->checador->present()->nombreCompleto), '', 1, 'L');

        $this->SetFont('Arial', 'B', $this->txtContenidoTam);
        $this->Cell(0.2 * $this->WidthTotal, 0.45, utf8_decode('FECHA y HORA DEL CORTE:'), '', 0, 'L');
        $this->SetFont('Arial', '', $this->txtContenidoTam);
        $this->CellFitScale(0.3 * $this->WidthTotal, 0.5, utf8_decode($this->corte->timestamp->format('d-M-Y h:i:s a')), '', 1, 'L');

        $this->SetFont('Arial', 'B', $this->txtContenidoTam);
        $this->Cell(0.2 * $this->WidthTotal, 0.45, utf8_decode('NÚMERO DE VIAJES:'), '', 0, 'L');
        $this->SetFont('Arial', '', $this->txtContenidoTam);
        $this->CellFitScale(0.3 * $this->WidthTotal, 0.5, utf8_decode($this->corte->corte_detalles->count()), '', 1, 'L');
    }

    public function encabezado_modificados() {
        $this->SetWidths(array(0));
        $this->SetFills(array('255,255,255'));
        $this->SetTextColors(array('1,1,1'));
        $this->SetRounds(array('0'));
        $this->SetRadius(array(0));
        $this->SetHeights(array(0));
        $this->Row(Array(''));
        $this->SetFont('Arial', 'B', $this->txtSeccionTam);
        $this->SetTextColors(array('255,255,255'));
        $this->CellFitScale($this->WidthTotal, 1, utf8_decode($this->tipo.' ('.$this->num_items.')'), 0, 1, 'L');
        $this->SetFont('Arial', 'B', 6);
        $this->SetStyles(array('DF', 'DF', 'DF', 'DF', 'DF','DF', 'DF', 'DF', 'DF', 'DF', 'DF', 'DF', 'DF', 'DF', 'DF'));
        $this->widths_items_modificados();
        $this->SetRounds(array('1', '', '', '', '', '', '', '', '', '', '', '', '', '', '2'));
        $this->SetRadius(array(0.2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.2));
        $this->SetFills(array('180,180,180', '180,180,180', '180,180,180','180,180,180', '180,180,180', '180,180,180','180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180'));
        $this->SetTextColors(array('0,0,0', '0,0,0', '0,0,0','0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0'));
        $this->SetHeights(array(0.3));
        $this->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));
        $this->Row(array(
            "#",
            utf8_decode("Camión"),
            utf8_decode("Código"),
            "Fecha y Hora Llegada",
            "Origen",
            "Tiro",
            "Material",
            utf8_decode("Cubic. (m3)"),
            utf8_decode("Checador Primer Toque"),
            utf8_decode("Checador Segundo Toque"),
            "Origen Nuevo",
            "Tiro Nuevo",
            "Material Nuevo",
            "Cubic. Nueva (m3)",
            utf8_decode("Justificación")));
    }

    public function encabezado_no_modificados() {
        $this->SetWidths(array(0));
        $this->SetFills(array('255,255,255'));
        $this->SetTextColors(array('1,1,1'));
        $this->SetRounds(array('0'));
        $this->SetRadius(array(0));
        $this->SetHeights(array(0));
        $this->Row(Array(''));
        $this->SetFont('Arial', 'B', $this->txtSeccionTam);
        $this->SetTextColors(array('255,255,255'));
        $this->CellFitScale($this->WidthTotal, 1, utf8_decode($this->tipo.' ('.$this->num_items.')'), 0, 1, 'L');
        $this->SetFont('Arial', 'B', 6);
        $this->SetStyles(array('DF', 'DF', 'DF', 'DF','DF', 'DF', 'DF', 'DF', 'DF', 'DF'));
        $this->widths_items_no_modificados();
        $this->SetRounds(array('1', '', '', '', '', '', '', '', '','2'));
        $this->SetRadius(array(0.2, 0, 0, 0, 0, 0, 0, 0, 0, 0.2));
        $this->SetFills(array('180,180,180','180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180'));
        $this->SetTextColors(array('0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0'));
        $this->SetHeights(array(0.5));
        $this->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));
        $this->Row(array(
            "#",
            utf8_decode("Camión"),
            utf8_decode("Código"),
            "Fecha y Hora Llegada",
            "Origen",
            "Tiro",
            "Material",
            utf8_decode("Cubic. (m3)"),
            utf8_decode("Checador Primer Toque"),
            utf8_decode("Checador Segundo Toque")));

    }

    public function encabezado_totales() {
        $this->SetWidths(array(0));
        $this->SetFills(array('255,255,255'));
        $this->SetTextColors(array('1,1,1'));
        $this->SetRounds(array('0'));
        $this->SetRadius(array(0));
        $this->SetHeights(array(0));
        $this->Row(Array(''));
        $this->SetFont('Arial', 'B', $this->txtSeccionTam);
        $this->SetTextColors(array('255,255,255'));
        $this->CellFitScale($this->WidthTotal, 1, utf8_decode($this->tipo), 0, 1, 'L');
        $this->SetFont('Arial', 'B', 6);
        $this->SetStyles(array('DF', 'DF', 'DF', 'DF','DF', 'DF', 'DF'));
        $this->widths_totales();
        $this->SetRounds(array('1', '', '', '', '', '', '2'));
        $this->SetRadius(array(0.2, 0, 0, 0, 0, 0, 0.2));
        $this->SetFills(array('180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180'));
        $this->SetTextColors(array('0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0'));
        $this->SetHeights(array(0.5));
        $this->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C'));
        $this->Row(array(
            utf8_decode("Origen"),
            utf8_decode("Móviles Modificados"),
            utf8_decode("Móviles No Modificados"),
            utf8_decode("Manuales Modificados"),
            utf8_decode("Manuales No Modificados"),
            utf8_decode("No Confirmados"),
            utf8_decode("Total")));
    }

    function items_modificados($items, $tipo)
    {
        $numItems = count($items);
        $this->num_items = $numItems;
        $this->tipo = $tipo;
        $this->encola = 'modificados';

        $this->encabezado_modificados();

        foreach ($items as $key => $item) {
            $this->SetFont('Arial', '', 5);
            $this->widths_items_modificados();
            $this->SetRounds(array('', '', '', '', '','', '', '', '', '','', '', '', '', ''));
            $this->SetRadius(array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0,0, 0, 0, 0, 0));
            $this->SetFills(array('255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255'));
            $this->SetTextColors(array('0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0'));
            $this->SetHeights(array(0.35));
            $this->SetAligns(array('C', 'L', 'L', 'L', 'L', 'L','L', 'R', 'L', 'L', 'L', 'L', 'L', 'R', 'L'));

            if ($key + 1 == $numItems ) {
                $this->SetRounds(array('4', '', '', '', '', '',  '', '', '', '', '', '', '', '', '3'));
                $this->SetRadius(array(0.2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.2));
            }
            $this->widths_items_modificados();
            $this->Row(array(
                $key + 1,
                $item->camion,
                $item->Code,
                $item->FechaHoraLlegada,
                utf8_decode($item->origen),
                utf8_decode($item->tiro),
                utf8_decode($item->material),
                $item->CubicacionCamion,
                utf8_decode($item->creo_primer_toque),
                utf8_decode($item->creo_segundo_toque),
                utf8_decode($item->origen_nuevo),
                utf8_decode($item->tiro_nuevo),
                utf8_decode($item->material_nuevo),
                utf8_decode($item->cubicacion_nueva),
                utf8_decode($item->justificacion)
            ));
        }
    }

    function items_no_modificados($items, $tipo)
    {
        $numItems = count($items);
        $this->num_items = $numItems;
        $this->tipo = $tipo;
        $this->encola = 'no_modificados';

        $this->encabezado_no_modificados();

        foreach ($items as $key => $item) {
            $this->SetFont('Arial', '', 5);
            $this->widths_items_no_modificados();
            $this->SetRounds(array('', '', '', '', '', '', '', '', '',''));
            $this->SetRadius(array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0));
            $this->SetFills(array('255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255'));
            $this->SetTextColors(array('0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0'));
            $this->SetHeights(array(0.35));
            $this->SetAligns(array('C', 'L', 'L', 'L', 'L', 'L', 'L', 'R', 'L', 'L'));

            if ($key + 1 == $numItems ) {
                $this->SetRounds(array('4', '', '', '', '', '', '', '', '', '3'));
                $this->SetRadius(array(0.2, 0, 0, 0, 0, 0, 0, 0, 0, 0.2));
            }
            $this->widths_items_no_modificados();
            $this->Row(array(
                $key + 1,
                $item->camion,
                $item->Code,
                $item->FechaHoraLlegada,
                utf8_decode($item->origen),
                utf8_decode($item->tiro),
                utf8_decode($item->material),
                $item->CubicacionCamion,
                utf8_decode($item->creo_primer_toque),
                utf8_decode($item->creo_segundo_toque)
            ));
        }
    }

    public function totales($items) {
        $numItems = count($items);

        $this->num_items = $numItems;
        $this->tipo = 'ACUMULADO DE VIAJES POR ORIGEN';
        $this->encola = 'totales';

        $this->encabezado_totales();

        foreach ($this->corte->origenes() as $key => $item) {
            $this->SetFont('Arial', '', 5);
            $this->widths_totales();
            $this->SetRounds(array('', '', '', '', '', '', ''));
            $this->SetRadius(array(0, 0, 0, 0, 0, 0, 0));
            $this->SetFills(array('255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '255,255,255', '180,180,180'));
            $this->SetTextColors(array('0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0'));
            $this->SetHeights(array(0.35));
            $this->SetAligns(array('L', 'R', 'R', 'R', 'R', 'R', 'R'));

            $this->widths_totales();

            $col_1 = count($this->corte->viajes_moviles_modificados()->where('viajesnetos.IdOrigen', '=', $item->IdOrigen)->get());
            $col_2 = count($this->corte->viajes_moviles_no_modificados()->where('viajesnetos.IdOrigen', '=', $item->IdOrigen)->get());
            $col_3 = count($this->corte->viajes_manuales_modificados()->where('viajesnetos.IdOrigen', '=', $item->IdOrigen)->get());
            $col_4 = count($this->corte->viajes_manuales_no_modificados()->where('viajesnetos.IdOrigen', '=', $item->IdOrigen)->get());
            $col_5 = count($this->corte->viajes_moviles_no_confirmados()->where('viajesnetos.IdOrigen', '=', $item->IdOrigen)->get());
            $col_6 = $col_1 + $col_2 + $col_3 + $col_4 + $col_5;

            $this->totales[1] += $col_1;
            $this->totales[2] += $col_2;
            $this->totales[3] += $col_3;
            $this->totales[4] += $col_4;
            $this->totales[5] += $col_5;
            $this->totales[6] += $col_6;

            $this->Row(array(
                utf8_decode($item->Descripcion),
                $col_1,
                $col_2,
                $col_3,
                $col_4,
                $col_5,
                $col_6
            ));
        }
        $this->encola = 'total';

        $this->SetFont('Arial', 'B', 5);
        $this->widths_totales();
        $this->SetRounds(array('', '', '', '', '', '', ''));
        $this->SetRadius(array(0, 0, 0, 0, 0, 0, 0));
        $this->SetFills(array('180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '180,180,180', '0,0,0'));
        $this->SetTextColors(array('0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '0,0,0', '255,255,255'));
        $this->SetHeights(array(0.35));
        $this->SetAligns(array('L', 'R', 'R', 'R', 'R', 'R', 'R'));
        $this->SetRounds(array('4', '', '', '', '', '', '3'));
        $this->SetRadius(array(0.2, 0, 0, 0, 0, 0, 0.2));

        $this->Row(
            $this->totales
        );

    }

    function Footer()
    {
        $this->SetY($this->GetPageHeight() - 1);
        $this->SetFont('Arial', '', $this->txtFooterTam);
        $this->SetTextColor('0', '0', '0');
        $this->Cell(6.5, .4, utf8_decode('Fecha de Consulta: ' . date('Y-m-d g:i a')), 0, 0, 'L');
        $this->SetFont('Arial', 'B', $this->txtFooterTam);
        $this->Cell(13.5, .4, '', 0, 0, 'C');
        $this->Cell(6.5, .4, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'R');
        $this->SetY($this->GetPageHeight() - 1.3);
        $this->SetFont('Arial', 'B', $this->txtFooterTam);
        $this->Cell(6.5, .4, utf8_decode('Formato generado desde el módulo de Control de Acarreos.'), 0, 0, 'L');

        if($this->corte->estatus == 1) {
            $this->SetFont('Arial', '', 75);
            $this->SetTextColor(204, 204, 204);
            $this->RotatedText(1.5, 21, utf8_decode("PENDIENTE DE CIERRE"), 39);
            $this->SetTextColor('0,0,0');
        }

    }

    function RotatedText($x,$y,$txt,$angle)
    {
        $this->Rotate($angle,$x,$y);
        $this->Text($x,$y,$txt);
        $this->Rotate(0);
    }

    function create() {
        $this->SetMargins(1, 0.5, 1);
        $this->AliasNbPages();
        $this->AddPage();
        $this->SetAutoPageBreak(true,2);
        if(count($this->corte->viajes_manuales_modificados()->get())) {
            $this->items_modificados($this->corte->viajes_manuales_modificados()->get(), 'VIAJES MANUALES MODIFICADOS');
            $this->Ln(1);
        }
        if(count($this->corte->viajes_manuales_no_modificados()->get())) {
            $this->items_no_modificados($this->corte->viajes_manuales_no_modificados()->get(), 'VIAJES MANUALES NO MODIFICADOS');
            $this->Ln(1);
        }
        if(count($this->corte->viajes_moviles_modificados()->get())) {
            $this->items_modificados($this->corte->viajes_moviles_modificados()->get(), 'VIAJES MÓVILES MODIFICADOS');
            $this->Ln(1);
        }
        if(count($this->corte->viajes_moviles_no_modificados()->get())) {
            $this->items_no_modificados($this->corte->viajes_moviles_no_modificados()->get(), 'VIAJES MÓVILES NO MODIFICADOS');
            $this->Ln(1);
        }
        if(count($this->corte->viajes_moviles_no_confirmados()->get())) {
            $this->items_no_modificados($this->corte->viajes_moviles_no_confirmados()->get(), 'VIAJES NO CONFIRMADOS POR EL CHECADOR');
            $this->Ln(1);
        }

        $this->totales($this->corte->origenes());
        $this->Output('I', "Corte{$this->corte->id}.pdf", 1);
        exit;
    }
}