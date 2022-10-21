<?php
/**
 * KanbanItemCalendarForm Form
 * @author  <your name here>
 */
class KanbanItemCalendarFormView extends TPage
{
    private $fc;

    /**
     * Page constructor
     */
    public function __construct($param = null)
    {
        parent::__construct();

        $this->fc = new TFullCalendar(date('Y-m-d'), 'month');
        $this->fc->enableDays([1,2,3,4,5]);
        $this->fc->setReloadAction(new TAction(array($this, 'getEvents'), $param));
        $this->fc->setDayClickAction(new TAction(array('KanbanItemCalendarForm', 'onStartEdit')));
        $this->fc->setEventClickAction(new TAction(array('KanbanItemCalendarForm', 'onEdit')));
        $this->fc->setEventUpdateAction(new TAction(array('KanbanItemCalendarForm', 'onUpdateEvent')));
        $this->fc->setCurrentView('month');
        $this->fc->setTimeRange('07:00', '19:00');
        $this->fc->enablePopover(' {titulo} ', " Projeto:  {projeto->titulo}<br>
Descrição: {descricao} ");
        $this->fc->setOption('slotTime', "00:30:00");
        $this->fc->setOption('slotDuration', "00:30:00");
        $this->fc->setOption('slotLabelInterval', 30);

        parent::add( $this->fc );
    }

    /**
     * Output events as an json
     */
    public static function getEvents($param=NULL)
    {
        $return = array();
        try
        {
            TTransaction::open('gestao');

            $criteria = new TCriteria(); 

            $criteria->add(new TFilter('datahora_inicio', '<=', substr($param['end'], 0, 10).' 23:59:59'));
            $criteria->add(new TFilter('datahora_fim', '>=', substr($param['start'], 0, 10).' 00:00:00'));

            $events = KanbanItem::getObjects($criteria);

            if ($events)
            {
                foreach ($events as $event)
                {
                    $event_array = $event->toArray();
                    $event_array['start'] = str_replace( ' ', 'T', $event_array['datahora_inicio']);
                    $event_array['end'] = str_replace( ' ', 'T', $event_array['datahora_fim']);
                    $event_array['id'] = $event->id;
                    $event_array['color'] = $event->render("{status->cor}");
                    $event_array['title'] = TFullCalendar::renderPopover($event->render("{titulo} "), $event->render(" {titulo} "), $event->render(" Projeto:  {projeto->titulo}<br>
Descrição: {descricao} "));

                    $return[] = $event_array;
                }
            }
            TTransaction::close();
            echo json_encode($return);
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }

    /**
     * Reconfigure the callendar
     */
    public function onReload($param = null)
    {
        if (isset($param['view']))
        {
            $this->fc->setCurrentView($param['view']);
        }

        if (isset($param['date']))
        {
            $this->fc->setCurrentDate($param['date']);
        }
    }

}

