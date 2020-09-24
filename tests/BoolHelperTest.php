<?php

use PHPUnit\Framework\TestCase;
use PHPTools\BoolHelper;
use PHPTools\StringHelper;

final class BoolHelperTest extends TestCase
{
	protected $true_scalars = [true, 1, 2, -1, -2, 1.001, -1.001];
	protected $false_scalars = [false, 0, 0.0, null];
	protected $true_strings = ['ae', 'ano', 'asli', 'bai', 'benetako', 'bəli', 'bẹẹni', 'da', 'dhabta ah', 'e', 'ea sebele', 'echt', 'ee', 'eh', 'eny', 'evet', 'ezigbo', 'fíor', 'gerçek', 'gidi', 'go iawn', 'ha', 'haa', 'halisi', 'haqiqiy', 'ie', 'igen', 'inde', 'iva', 'iya nih', 'ja', 'jah', 'joo', 'já', 'jā', 'ndiyo', 'nekilnojamasis', 'nuhun', 'nyata', 'oo', 'oui', 'po', 'pravi', 'prawdziwy', 'real', 'reali', 'reyèl', 'reāls', 'sebenar', 'si', 'sim', 'skutečný', 'skutočný', 'sì', 'sí', 'taip', 'tak', 'tena', 'thực', 'tinuod nga', 'true', 'tá', 'tõeline', 'tūturu', 'valódi', 'vero', 'vrai', 'vâng', 'weniweni', 'werklike', 'wi', 'ya', 'yebo', 'yes', 'áno', 'ναί', 'πραγματικός', 'да', 'бодит', 'вистински', 'воқеӣ', 'да', 'ды', 'иә', 'прави', 'реален', 'реальний', 'реальный', 'рэальны', 'так', 'тийм ээ', 'шын', 'ҳа', 'այո', 'իրական', 'אמיתי', 'כן', 'פאַקטיש', 'اصلی', 'بله', 'جی ہاں', 'حقيقي', 'نعم فعلا', 'واقعی', 'असली', 'रिअल', 'वास्तविक', 'हाँ', 'हो', 'होय', 'বাস্তব', 'হাঁ', 'ਅਸਲੀ', 'ਹਾਂ', 'વાસ્તવિક', 'હા', 'ஆம்', 'உண்மையான', 'అవును', 'నిజమైన', 'ನಿಜವಾದ', 'ಹೌದು', 'അതെ', 'യഥാർത്ഥ', 'ඔව්', 'සැබෑ', 'จริง', 'ใช่', 'ທີ່ແທ້ຈິງ', 'ແມ່ນແລ້ວ', 'စစ်မှန်သော', 'ဟုတ်ကဲ့', 'დიახ', 'რეალური', 'បាទ', 'ពិតប្រាកដ', 'はい', 'リアル', '实', '實', '是', '예', '현실'];
	protected $false_strings = ['0', '', 'amanga', 'ayi', 'babu', 'bakak', 'been ah', 'bohata', 'br', 'bréagach', 'cha', 'che', 'dili', 'dim', 'diso', 'ee e', 'ei', 'eke', 'fals', 'falsch', 'false', 'falsk', 'falso', 'faltsua', 'falz', 'faux', 'fałszywy', 'ffug', 'fo', 'geen', 'hamis', 'hapana', 'hindi', 'huwad', 'ingen', 'jo', 'không', 'klaidinga', 'lažan', 'lažno', 'le', 'maya', 'napačen', 'ne', 'nee', 'nei', 'nein', 'nej', 'nem', 'nepravdivé', 'nepravdivý', 'nie', 'no', 'non', 'noto\'g\'ri', 'nr', 'nu', 'nē', 'onwaar', 'ora', 'pa gen okenn', 'palsu', 'rangt', 'rara', 'sai', 'salah', 'teka', 'teu', 'tidak', 'tsy misy', 'uimh', 'uongo', 'vale', 'vals', 'viltus', 'väärä', 'yanlış', 'yo\'q', 'yok hayır', 'yox', 'zabodza', 'št', 'žiadny', 'ƙarya', 'ψευδής', 'όχι', 'Не', 'бр', 'жалған', 'жоқ', 'лажно', 'ложный', 'не', 'немає', 'нет', 'неточно', 'нодуруст', 'няма', 'помилковий', 'фалшив', 'фальшывы', 'худал', 'Үгүй', 'կեղծ', 'ոչ', 'לא', 'שֶׁקֶר', 'خاطئة', 'غلط', 'لا', 'نادرست', 'نه', 'نہیں', 'असत्य', 'खोटे', 'गलत', 'नहीं', 'नाही', 'না', 'মিথ্যা', 'ਝੂਠ', 'ਨਹੀਂ', 'ખોટા', 'ના', 'இல்லை', 'தவறான', 'ఏ', 'తప్పుడు', 'ಇಲ್ಲ', 'ಸುಳ್ಳು', 'ഇല്ല', 'തെറ്റായ', 'අසත්යය', 'නැත', 'เท็จ', 'ไม่', 'ບໍ່ຖືກຕ້ອງ', 'မမှန်သော', 'အဘယ်သူမျှမ', 'არა', 'ყალბი', 'ទេ', 'មិនពិត', 'ụgha', '假', '偽', '沒有', '没有', '그릇된', '아니'];

	public function testIsTrueString()
	{
		foreach ($this->true_strings as $string)
		{
			$this->assertTrue(BoolHelper::is_true_string($string), "'$string' is false, should be true.");
		}
		foreach ($this->false_strings as $string)
		{
			$this->assertFalse(BoolHelper::is_true_string($string), "'$string' is true, should be false.");
		}
	}

	public function testToBool()
	{
		foreach ($this->true_strings as $string)
		{
			$this->assertTrue(BoolHelper::to_bool($string), "'$string' is false, should be true.");
		}
		foreach ($this->true_scalars as $scalar)
		{
			$this->assertTrue(BoolHelper::to_bool($scalar), "Scalar $scalar is false, should be true.");
		}
		foreach ($this->false_strings as $string)
		{
			$this->assertFalse(BoolHelper::to_bool($string), "'$string' is true, should be false.");
		}
		foreach ($this->false_scalars as $scalar)
		{
			$this->assertFalse(BoolHelper::to_bool($scalar), "Scalar $scalar is true, should be false.");
		}
	}

	public function testIsFalseString()
	{
		foreach ($this->true_strings as $string)
		{
			$this->assertFalse(BoolHelper::is_false_string($string), "'$string' is false, should be true.");
			// $this->assertFalse(BoolHelper::is_false_string($up = mb_strtoupper($string)), "'$up' is false, should be true.");
		}
		foreach ($this->false_strings as $string)
		{
			$this->assertTrue(BoolHelper::is_false_string($string), "'$string' is true, should be false.");
			// $this->assertTrue(BoolHelper::is_false_string($up = mb_strtoupper($string)), "'$up' is true, should be false.");
		}
	}

	public function testAddFalseString()
	{
		BoolHelper::add_false_string('N');
		$this->assertTrue(BoolHelper::is_false_string('n'), "'n' is true, should be false.");
		$this->assertTrue(BoolHelper::is_false_string('N'), "'N' is true, should be false.");
	}

	public function testAddTrueString()
	{
		BoolHelper::add_true_string('Y');
		$this->assertTrue(BoolHelper::is_true_string('y'), "'y' is false, should be true.");
		$this->assertTrue(BoolHelper::is_true_string('Y'), "'Y' is false, should be true.");
	}
}