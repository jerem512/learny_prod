<?php

namespace App\Services;

class EventCalendarService
{
    public function makeEventCalendarService($events, $user_mail){
        $case = [];

        foreach ($events->{'items'} as $event) {
            if(isset($event->{'colorId'})){
                switch ($event->{'colorId'}) {
                    case '1':
                        $color = '#7887cb';
                        $borderColor = '#7887cb';
                        break;
                    case '2':
                        $color = '#34b579';
                        $borderColor = '#34b579';
                        break;
                    case '3':
                        $color = '#8f24aa';
                        $borderColor = '#8f24aa';
                        break;
                    case '4':
                        $color = '#e77c73';
                        $borderColor = '#e77c73';
                        break;
                    case '5':
                        $color = '#f6be25';
                        $borderColor = '#f6be25';
                        break;
                    case '6':
                        $color = '#f5511e';
                        $borderColor = '#f5511e';
                        break;

                    case '8':
                        $color = '#616161';
                        $borderColor = '#616161';
                        break;
                    case '9':
                        $color = '#4050b5';
                        $borderColor = '#4050b5';
                        break;
                    case '10':
                        $color = '#0c8043';
                        $borderColor = '#0c8043';
                        break;
                    case '11':
                        $color = '#d50001';
                        $borderColor = '#d50001';
                        break;
                    default:
                        $color = '#059be5';
                        $borderColor = '#059be5';
                        break;
                }
            }else{
                $color = '#059be5';
                $borderColor = '#059be5';
            }

            $textColor = '#FFFFFF';
            $className = '';

            if(isset($event->{'transparency'})){
                $color = '#FFFFFF';
                $borderColor = '#059be5';
                $textColor = '#059be5';
                $className = 'cancel';
            }

            if(isset($event->{'summary'})){
                $title = $event->{'summary'};
            }else{
                $title = '(Sans titre)';
            }
            if(isset($event->{'start'}->{'dateTime'}) && isset($event->{'end'}->{'dateTime'})){
                $start = $event->{'start'}->{'dateTime'};
                $end = $event->{'end'}->{'dateTime'};
            }else{
                $start = $event->{'start'}->{'date'};
                $end = $event->{'end'}->{'date'};
            }
            
            if(isset($event->{'attendees'})){
                if($event->{'attendees'}[0]->{'email'} == $user_mail){
                    $invitee = $event->{'attendees'}[1]->{'email'};
                    if($event->{'attendees'}[1]->{'responseStatus'} == 'declined'){
                        $color = '#FFFFFF';
                        $borderColor = '#059be5';
                        $textColor = '#059be5';
                    }
                }else{
                    $invitee = $event->{'attendees'}[0]->{'email'};
                    if($event->{'attendees'}[0]->{'responseStatus'} == 'declined'){
                        $color = '#FFFFFF';
                        $borderColor = '#059be5';
                        $textColor = '#059be5';
                    }
                }
            }else{
                $invitee = '';
            }
            $case[] = [
                'start' => $start,
                'end' => $end,
                'title' => $title,   
                'className' => $className,                
                'backgroundColor' => $color,
                'borderColor' => $borderColor,
                'textColor' => $textColor,
                'invitee' => $invitee
            ];
            
        }

        return $case;
    }
}