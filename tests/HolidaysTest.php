<?php

use PHPTools\Holidays;
use PHPUnit\Framework\TestCase;

final class HolidaysTest extends TestCase
{
	public function test_get_rule()
	{
		$this->assertNotNull(Holidays::get_rule('FR', 'christmas'));
		$this->assertNotNull(Holidays::get_rule('FR', 'easter'));
		$this->assertNull(Holidays::get_rule('US_CA', 'easter'));
		$this->assertNotNull(Holidays::get_rule('US_CA', 'easter', true));
	}

	public function test_get_holiday_fr()
	{
		$this->assertEquals('2020-01-01', Holidays::get_holiday('new_year', 2020, 'FR')->format('Y-m-d'));
		$this->assertEquals('2020-04-12', Holidays::get_holiday('easter', 2020, 'FR')->format('Y-m-d'));
		$this->assertEquals('2020-04-13', Holidays::get_holiday('lundi_paques', 2020, 'FR')->format('Y-m-d'));
		$this->assertEquals('2020-05-01', Holidays::get_holiday('travail', 2020, 'FR')->format('Y-m-d'));
		$this->assertEquals('2020-05-08', Holidays::get_holiday('armistice_1945', 2020, 'FR')->format('Y-m-d'));
		$this->assertEquals('2020-05-21', Holidays::get_holiday('ascension', 2020, 'FR')->format('Y-m-d'));
		$this->assertEquals('2020-06-01', Holidays::get_holiday('pentecote', 2020, 'FR')->format('Y-m-d'));
		$this->assertEquals('2020-07-14', Holidays::get_holiday('national', 2020, 'FR')->format('Y-m-d'));
		$this->assertEquals('2020-08-15', Holidays::get_holiday('assomption', 2020, 'FR')->format('Y-m-d'));
		$this->assertEquals('2020-11-01', Holidays::get_holiday('toussaint', 2020, 'FR')->format('Y-m-d'));
		$this->assertEquals('2020-11-11', Holidays::get_holiday('armistice_1918', 2020, 'FR')->format('Y-m-d'));
		$this->assertEquals('2020-12-25', Holidays::get_holiday('christmas', 2020, 'FR')->format('Y-m-d'));
	}

	public function test_get_holiday_fr_alsace()
	{
		$this->assertEquals('2020-01-01', Holidays::get_holiday('new_year', 2020, 'FR_Alsace')->format('Y-m-d'));
		$this->assertEquals('2020-04-10', Holidays::get_holiday('vendredi_saint', 2020, 'FR_Alsace')->format('Y-m-d'));
		$this->assertEquals('2020-04-12', Holidays::get_holiday('easter', 2020, 'FR_Alsace')->format('Y-m-d'));
		$this->assertEquals('2020-04-13', Holidays::get_holiday('lundi_paques', 2020, 'FR_Alsace')->format('Y-m-d'));
		$this->assertEquals('2020-05-01', Holidays::get_holiday('travail', 2020, 'FR_Alsace')->format('Y-m-d'));
		$this->assertEquals('2020-05-08', Holidays::get_holiday('armistice_1945', 2020, 'FR_Alsace')->format('Y-m-d'));
		$this->assertEquals('2020-05-21', Holidays::get_holiday('ascension', 2020, 'FR_Alsace')->format('Y-m-d'));
		$this->assertEquals('2020-06-01', Holidays::get_holiday('pentecote', 2020, 'FR_Alsace')->format('Y-m-d'));
		$this->assertEquals('2020-07-14', Holidays::get_holiday('national', 2020, 'FR_Alsace')->format('Y-m-d'));
		$this->assertEquals('2020-08-15', Holidays::get_holiday('assomption', 2020, 'FR_Alsace')->format('Y-m-d'));
		$this->assertEquals('2020-11-01', Holidays::get_holiday('toussaint', 2020, 'FR_Alsace')->format('Y-m-d'));
		$this->assertEquals('2020-11-11', Holidays::get_holiday('armistice_1918', 2020, 'FR_Alsace')->format('Y-m-d'));
		$this->assertEquals('2020-12-25', Holidays::get_holiday('christmas', 2020, 'FR_Alsace')->format('Y-m-d'));
		$this->assertEquals('2020-12-26', Holidays::get_holiday('christmas_next', 2020, 'FR_Alsace')->format('Y-m-d'));
	}

	public function test_get_holiday_us()
	{
		$this->assertEquals('2020-01-01', Holidays::get_holiday('new_year', 2020, 'US')->format('Y-m-d'));
		$this->assertEquals('2020-01-20', Holidays::get_holiday('martin_luther_king', 2020, 'US')->format('Y-m-d'));
		$this->assertEquals('2020-02-17', Holidays::get_holiday('president', 2020, 'US')->format('Y-m-d'));
		$this->assertEquals('2020-05-25', Holidays::get_holiday('memorial', 2020, 'US')->format('Y-m-d'));
		$this->assertEquals('2020-07-04', Holidays::get_holiday('independance', 2020, 'US')->format('Y-m-d'));
		$this->assertEquals('2020-09-07', Holidays::get_holiday('labor', 2020, 'US')->format('Y-m-d'));
		$this->assertEquals('2020-10-12', Holidays::get_holiday('columbus', 2020, 'US')->format('Y-m-d'));
		$this->assertEquals('2020-11-11', Holidays::get_holiday('veterans', 2020, 'US')->format('Y-m-d'));
		$this->assertEquals('2020-11-26', Holidays::get_holiday('thanksgiving', 2020, 'US')->format('Y-m-d'));
		$this->assertEquals('2020-12-25', Holidays::get_holiday('christmas', 2020, 'US')->format('Y-m-d'));
	}

	public function test_get_holiday_us_ca()
	{
		$this->assertEquals('2020-01-01', Holidays::get_holiday('new_year', 2020, 'US_CA')->format('Y-m-d'));
		$this->assertEquals('2020-01-20', Holidays::get_holiday('martin_luther_king', 2020, 'US_CA')->format('Y-m-d'));
		$this->assertEquals('2020-02-17', Holidays::get_holiday('president', 2020, 'US_CA')->format('Y-m-d'));
		$this->assertEquals('2020-04-10', Holidays::get_holiday('good_friday', 2020, 'US_CA')->format('Y-m-d'));
		$this->assertEquals('2020-05-25', Holidays::get_holiday('memorial', 2020, 'US_CA')->format('Y-m-d'));
		$this->assertEquals('2020-07-04', Holidays::get_holiday('independance', 2020, 'US_CA')->format('Y-m-d'));
		$this->assertEquals('2020-09-07', Holidays::get_holiday('labor', 2020, 'US_CA')->format('Y-m-d'));
		$this->assertEquals('2020-10-12', Holidays::get_holiday('columbus', 2020, 'US_CA')->format('Y-m-d'));
		$this->assertEquals('2020-11-11', Holidays::get_holiday('veterans', 2020, 'US_CA')->format('Y-m-d'));
		$this->assertEquals('2020-11-26', Holidays::get_holiday('thanksgiving', 2020, 'US_CA')->format('Y-m-d'));
		$this->assertEquals('2020-12-25', Holidays::get_holiday('christmas', 2020, 'US_CA')->format('Y-m-d'));
	}

	public function test_get_rules_fr()
	{
		$rules = Holidays::get_country_rules('FR');
		$this->assertEqualsCanonicalizing([
			'new_year',
			'easter',
			'christmas',
			'lundi_paques',
			'ascension',
			'pentecote',
			'travail',
			'armistice_1945',
			'national',
			'assomption',
			'toussaint',
			'armistice_1918'
		], $rules->keys()->getArrayCopy());
	}

	public function test_get_rules_fr_alsace()
	{
		$rules = Holidays::get_country_rules('FR_Alsace');
		$this->assertEqualsCanonicalizing([
			'vendredi_saint',
			'christmas_next',
			'new_year',
			'easter',
			'christmas',
			'lundi_paques',
			'ascension',
			'pentecote',
			'travail',
			'armistice_1945',
			'national',
			'assomption',
			'toussaint',
			'armistice_1918'
		], $rules->keys()->getArrayCopy());
	}

	public function test_get_rules_us()
	{
		$rules = Holidays::get_country_rules('US');
		$this->assertEqualsCanonicalizing([
			'martin_luther_king',
			'president',
			'memorial',
			'independance',
			'labor',
			'columbus',
			'veterans',
			'thanksgiving',
			'new_year',
			'christmas',
		], $rules->keys()->getArrayCopy());
	}

	public function test_get_rules_us_ca()
	{
		$rules = Holidays::get_country_rules('US_CA');
		$this->assertEqualsCanonicalizing([
			'martin_luther_king',
			'president',
			'memorial',
			'independance',
			'labor',
			'columbus',
			'veterans',
			'thanksgiving',
			'new_year',
			'christmas',
			'good_friday',
		], $rules->keys()->getArrayCopy());
	}
}