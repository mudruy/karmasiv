<?php

/**
 * @author saymon
 */
class Parser
{

	/**
	 * @var string
	 */
	private $itemRowRegexp = '/^\<b\>(.*)?\<\/b\>(.*)$/Uis';

	/**
	 * @param string $html
	 * @return array
	 */
	private function _parseItem($html)
	{
// 		Logger::dump($html);
		$html = trim($html);
		$arrRows = explode("\n", $html);

		$arrItem = [];
		foreach ($arrRows as $strRow)
		{
			$strRow = trim($strRow);
			preg_match($this->itemRowRegexp, $strRow, $matches);

			$key = isset($matches[1]) ? $matches[1] : '???';
			$value = isset($matches[2]) ? $matches[2] : '???';

			$key	= trim($key, ' :');
			$value	= trim($value, ' :');

			$arrItem[$key] = $value;

		}

// 		Logger::dump($arrItem);
		return $arrItem;
	}

	/**
	 * @param array $arrItemData
	 * @return string
	 */
	private function _buildContent($arrItemData)
	{
		$content = '';
		foreach ($arrItemData as $key => $value)
		{
			switch ($key)
			{
				case 'Вид документа':
				case 'Шифр издания':
				case 'Автор(ы)':
				case 'Выходные данные':
				case 'Колич.характеристики':
				case 'ISBN,  Цена':
				case 'ГРНТИ':
				case 'УДК':
				case 'Предметные рубрики':
				case 'Ключевые слова':
				{
					$content .= '<p><span class="key">' . $key . '</span> <span class="value">' . $value . '</span></p>';
				}
			}

		}

		return $content;
	}

	/**
	 * @param array $arrHtmlContent
	 * @return array
	 */
	public function process($arrHtmlContent)
	{
		if (!is_array($arrHtmlContent))
		{
			return NULL;
		}

		$arrResult = [];
		foreach ($arrHtmlContent as $html)
		{
			$arrItemData = $this->_parseItem($html);

			$arrItem['title']		= $arrItemData['Заглавие'];
			$arrItem['content']	= $this->_buildContent($arrItemData);

			$arrResult[] = $arrItem;
		}

		return $arrResult;
	}

}