<?php

class CsrfFilter extends CFilter
{
    protected function preFilter($filterChain)
    {
        // Lakukan validasi token di sini untuk POST atau GET
        // $request = Yii::app()->getRequest();
        /* $isPostRequest = $request->getIsPostRequest();
        $isGetRequest = $request->getRequestType(); */

        $keyToken = Helper::getInstance()->hashSha256("token");
        if (empty(Helper::getInstance()->getState($keyToken))) {
            throw new CHttpException(403, 'Unauthorized');
        }

        return true;
    }

    protected function postFilter($filterChain)
    {
        // Kosongkan, karena ini adalah preFilter
    }

    private function getHeaders()
	{
		$headers = array();
		foreach ($_SERVER as $key => $value) {
			if (strpos($key, 'HTTP_') === 0) {
				$headers[str_replace(' ', '', str_replace('_', '-', substr($key, 5)))] = $value;
			}
		}

		return $headers;
	}
}
