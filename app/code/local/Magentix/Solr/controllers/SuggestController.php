<?php
/**
 * Created by Macopedia.
 * Developer: Jakub Cegiełka <j.cegielka@macopedia.pl>
 */

class Magentix_Solr_SuggestController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $query = $this->getRequest()->getParam('q');

        if ($query == null) {
             return 0;
        }


        $search = Mage::getModel('solr/search');
        $params = array();
        $params['url'] = 'suggester';
        $params['suggest'] = 1;

//        $this->getResponse()->setHeader('Content-type', 'application/json');
        $html = '<ul>';

        $response = $search->search($query, 0, 5, $params)->getRawResponse();
        $response = json_decode($response);
        foreach($response->spellcheck->suggestions->pie->suggestion as $suggestion){
            $html .= '<li>'.$suggestion.'</li>';
        }
        $html .= '</ul>';
        echo $html;
    }
}