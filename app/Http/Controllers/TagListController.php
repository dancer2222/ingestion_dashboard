<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TagListController extends Controller
{
    /**
     * @return array
     */
    public static function getTagList()
    {
        return [
            'addressee'                   => 'Addressee',
            'addresseeidentifier'         => 'AddresseeIdentifier',
            'm380'                        => 'AddresseeIDType',
            'x300'                        => 'AddresseeName',
            'b046'                        => 'Affiliation',
            'agentidentifier'             => 'AgentIdentifier',
            'j400'                        => 'AgentIDType',
            'j401'                        => 'AgentName',
            'j402'                        => 'AgentRole',
            'alternativename'             => 'AlternativeName',
            'ancillarycontent'            => 'AncillaryContent',
            'x423'                        => 'AncillaryContentType',
            'x424'                        => 'AncillaryContentDescription',
            'audience'                    => 'Audience',
            'b073'                        => 'AudienceCode',
            'b204'                        => 'AudienceCodeType',
            'b205'                        => 'AudienceCodeTypeName',
            'b206'                        => 'AudienceCodeValue',
            'b207'                        => 'AudienceDescription',
            'audiencerange'               => 'AudienceRange',
            'b075'                        => 'AudienceRangePrecision',
            'b074'                        => 'AudienceRangeQualifier',
            'b076'                        => 'AudienceRangeValue',
            'barcode'                     => 'Barcode',
            'x312'                        => 'BarcodeType',
            'batchbonus'                  => 'BatchBonus',
            'j264'                        => 'BatchQuantity',
            'bible'                       => 'Bible',
            'b352'                        => 'BibleContents',
            'b354'                        => 'BiblePurpose',
            'b356'                        => 'BibleReferenceLocation',
            'b357'                        => 'BibleTextFeature',
            'b355'                        => 'BibleTextOrganization',
            'b353'                        => 'BibleVersion',
            'b044'                        => 'BiographicalNote',
            'k169'                        => 'BookClubAdoption',
            'j375'                        => 'CBO',
            'x434'                        => 'CitationNote',
            'citedcontent'                => 'CitedContent',
            'x430'                        => 'CitedContentType',
            'b209'                        => 'CityOfPublication',
            'collateraldetail'            => 'CollateralDetail',
            'collection'                  => 'Collection',
            'collectionidentifier'        => 'CollectionIdentifier',
            'x344'                        => 'CollectionIDType',
            'collectionsequence'          => 'CollectionSequence',
            'x481'                        => 'CollectionSequenceNumber',
            'x479'                        => 'CollectionSequenceType',
            'x480'                        => 'CollectionSequenceTypeName',
            'x329'                        => 'CollectionType',
            'comparisonproductprice'      => 'ComparisonProductPrice',
            'complexity'                  => 'Complexity',
            'b078'                        => 'ComplexityCode',
            'b077'                        => 'ComplexitySchemeIdentifier',
            'b289'                        => 'ComponentNumber',
            'b288'                        => 'ComponentTypeName',
            'conference'                  => 'Conference',
            'b341'                        => 'ConferenceAcronym',
            'b054'                        => 'ConferenceDate',
            'b052'                        => 'ConferenceName',
            'b053'                        => 'ConferenceNumber',
            'b055'                        => 'ConferencePlace',
            'b051'                        => 'ConferenceRole',
            'conferencesponsor'           => 'ConferenceSponsor',
            'b391'                        => 'ConferenceSponsorIDType',
            'conferencesponsoridentifier' => 'ConferenceSponsorIdentifier',
            'b342'                        => 'ConferenceTheme',
            'x299'                        => 'ContactName',
            'x427'                        => 'ContentAudience',
            'contentdate'                 => 'ContentDate',
            'x429'                        => 'ContentDateRole',
            'contentdetail'               => 'ContentDetail',
            'contentitem'                 => 'ContentItem',
            'contributor'                 => 'Contributor',
            'contributordate'             => 'ContributorDate',
            'x417'                        => 'ContributorDateRole',
            'b048'                        => 'ContributorDescription',
            'contributorplace'            => 'ContributorPlace',
            'x418'                        => 'ContributorPlaceRelator',
            'b035'                        => 'ContributorRole',
            'b049'                        => 'ContributorStatement',
            'k168'                        => 'CopiesSold',
            'copyrightowner'              => 'CopyrightOwner',
            'b392'                        => 'CopyrightOwnerIDType',
            'copyrightowneridentifier'    => 'CopyrightOwnerIdentifier',
            'copyrightstatement'          => 'CopyrightStatement',
            'b087'                        => 'CopyrightYear',
            'b047'                        => 'CorporateName',
            'x443'                        => 'CorporateNameInverted',
            'x449'                        => 'CountriesIncluded',
            'x451'                        => 'CountriesExcluded',
            'b251'                        => 'CountryCode',
            'x316'                        => 'CountryOfManufacture',
            'b083'                        => 'CountryOfPublication',
            'j152'                        => 'CurrencyCode',
            'x475'                        => 'CurrencyZone',
            'b306'                        => 'Date',
            'j260'                        => 'DateFormat',
            'm186'                        => 'DefaultCurrencyCode',
            'm184'                        => 'DefaultLanguageOfText',
            'x310'                        => 'DefaultPriceType',
            'a199'                        => 'DeletionText',
            'descriptivedetail'           => 'DescriptiveDetail',
            'discount'                    => 'Discount',
            'x469'                        => 'DiscountAmount',
            'j364'                        => 'DiscountCode',
            'j363'                        => 'DiscountCodeType',
            'j378'                        => 'DiscountCodeTypeName',
            'discountcoded'               => 'DiscountCoded',
            'x317'                        => 'EpubTechnicalProtection',
            'b057'                        => 'EditionNumber',
            'b058'                        => 'EditionStatement',
            'x419'                        => 'EditionType',
            'b217'                        => 'EditionVersionNumber',
            'j272'                        => 'EmailAddress',
            'b325'                        => 'EndDate',
            'epubusageconstraint'         => 'EpubUsageConstraint',
            'epubusagelimit'              => 'EpubUsageLimit',
            'x319'                        => 'EpubUsageStatus',
            'x318'                        => 'EpubUsageType',
            'x321'                        => 'EpubUsageUnit',
            'j302'                        => 'ExpectedDate',
            'extent'                      => 'Extent',
            'b218'                        => 'ExtentType',
            'b220'                        => 'ExtentUnit',
            'b219'                        => 'ExtentValue',
            'x421'                        => 'ExtentValueRoman',
            'j271'                        => 'FaxNumber',
            'x440'                        => 'FeatureNote',
            'x439'                        => 'FeatureValue',
            'b286'                        => 'FirstPageNumber',
            'j265'                        => 'FreeQuantity',
            'x412'                        => 'FromLanguage',
            'header'                      => 'Header',
            'b233'                        => 'IDTypeName',
            'b244'                        => 'IDValue',
            'x422'                        => 'Illustrated',
            'b062'                        => 'IllustrationsNote',
            'imprint'                     => 'Imprint',
            'imprintidentifier'           => 'ImprintIdentifier',
            'x445'                        => 'ImprintIDType',
            'b079'                        => 'ImprintName',
            'k167'                        => 'InitialPrintRun',
            'b040'                        => 'KeyNames',
            'language'                    => 'Language',
            'b252'                        => 'LanguageCode',
            'b253'                        => 'LanguageRole',
            'b287'                        => 'LastPageNumber',
            'x446'                        => 'LatestReprintNumber',
            'b042'                        => 'LettersAfterNames',
            'b284'                        => 'LevelSequenceNumber',
            'x432'                        => 'ListName',
            'locationidentifier'          => 'LocationIdentifier',
            'j377'                        => 'LocationIDType',
            'j349'                        => 'LocationName',
            'x425'                        => 'MainSubject',
            'b063'                        => 'MapScale',
            'market'                      => 'Market',
            'marketdate'                  => 'MarketDate',
            'j408'                        => 'MarketDateRole',
            'marketpublishingdetail'      => 'MarketPublishingDetail',
            'j407'                        => 'MarketPublishingStatus',
            'x406'                        => 'MarketPublishingStatusNote',
            'measure'                     => 'Measure',
            'c094'                        => 'Measurement',
            'x315'                        => 'MeasureType',
            'c095'                        => 'MeasureUnitCode',
            'm183'                        => 'MessageNote',
            'm180'                        => 'MessageNumber',
            'm181'                        => 'MessageRepeat',
            'j263'                        => 'MinimumOrderQuantity',
            'nameassubject'               => 'NameAsSubject',
            'nameidentifier'              => 'NameIdentifier',
            'x415'                        => 'NameIDType',
            'b041'                        => 'NamesAfterKey',
            'b039'                        => 'NamesBeforeKey',
            'x414'                        => 'NameType',
            'newsupplier'                 => 'NewSupplier',
            'x411'                        => 'NoCollection',
            'n339'                        => 'NoContributor',
            'n386'                        => 'NoEdition',
            'a002'                        => 'NotificationType',
            'b257'                        => 'Number',
            'x323'                        => 'NumberOfCopies',
            'b125'                        => 'NumberOfIllustrations',
            'x322'                        => 'NumberOfItemsOfThisForm',
            'b061'                        => 'NumberOfPages',
            'ONIXmessage'                 => 'ONIXMessage',
            'j350'                        => 'OnHand',
            'j351'                        => 'OnOrder',
            'onorderdetail'               => 'OnOrderDetail',
            'j144'                        => 'OrderTime',
            'j145'                        => 'PackQuantity',
            'pagerun'                     => 'PageRun',
            'x410'                        => 'PartNumber',
            'b337'                        => 'Percent',
            'j267'                        => 'DiscountPercent',
            'b036'                        => 'PersonName',
            'b037'                        => 'PersonNameInverted',
            'x433'                        => 'PositionOnList',
            'x313'                        => 'PositionOnProduct',
            'b247'                        => 'PrefixToKey',
            'price'                       => 'Price',
            'j151'                        => 'PriceAmount',
            'x468'                        => 'PriceCode',
            'pricecoded'                  => 'PriceCoded',
            'x465'                        => 'PriceCodeType',
            'x477'                        => 'PriceCodeTypeName',
            'pricecondition'              => 'PriceCondition',
            'priceconditionquantity'      => 'PriceConditionQuantity',
            'x464'                        => 'PriceConditionQuantityType',
            'x463'                        => 'PriceConditionType',
            'pricedate'                   => 'PriceDate',
            'x476'                        => 'PriceDateRole',
            'j239'                        => 'PricePer',
            'j261'                        => 'PriceQualifier',
            'j266'                        => 'PriceStatus',
            'x462'                        => 'PriceType',
            'j262'                        => 'PriceTypeDescription',
            'x416'                        => 'PrimaryContentType',
            'x457'                        => 'PrimaryPart',
            'x301'                        => 'PrintedOnProduct',
            'prize'                       => 'Prize',
            'g129'                        => 'PrizeCode',
            'g128'                        => 'PrizeCountry',
            'g343'                        => 'PrizeJury',
            'g126'                        => 'PrizeName',
            'g127'                        => 'PrizeYear',
            'product'                     => 'Product',
            'j396'                        => 'ProductAvailability',
            'productclassification'       => 'ProductClassification',
            'b275'                        => 'ProductClassificationCode',
            'b274'                        => 'ProductClassificationType',
            'x314'                        => 'ProductComposition',
            'productcontact'              => 'ProductContact',
            'productcontactidentifier'    => 'ProductContactIdentifier',
            'x483'                        => 'ProductContactIDType',
            'x484'                        => 'ProductContactName',
            'x482'                        => 'ProductContactRole',
            'b385'                        => 'ProductContentType',
            'b012'                        => 'ProductForm',
            'b014'                        => 'ProductFormDescription',
            'b333'                        => 'ProductFormDetail',
            'productformfeature'          => 'ProductFormFeature',
            'b336'                        => 'ProductFormFeatureDescription',
            'b334'                        => 'ProductFormFeatureType',
            'b335'                        => 'ProductFormFeatureValue',
            'b221'                        => 'ProductIDType',
            'ProductIdentifier'           => 'ProductIdentifier',
            'b225'                        => 'ProductPackaging',
            'productpart'                 => 'ProductPart',
            'x455'                        => 'ProductRelationCode',
            'productsupply'               => 'ProductSupply',
            'professionalaffiliation'     => 'ProfessionalAffiliation',
            'b045'                        => 'ProfessionalPosition',
            'k165'                        => 'PromotionCampaign',
            'k166'                        => 'PromotionContact',
            'publisher'                   => 'Publisher',
            'publisheridentifier'         => 'PublisherIdentifier',
            'x447'                        => 'PublisherIDType',
            'b081'                        => 'PublisherName',
            'publisherrepresentative'     => 'PublisherRepresentative',
            'publishingdate'              => 'PublishingDate',
            'x448'                        => 'PublishingDateRole',
            'publishingdetail'            => 'PublishingDetail',
            'b291'                        => 'PublishingRole',
            'b394'                        => 'PublishingStatus',
            'b395'                        => 'PublishingStatusNote',
            'x320'                        => 'Quantity',
            'x466'                        => 'QuantityUnit',
            'x467'                        => 'DiscountType',
            'a001'                        => 'RecordReference',
            'recordsourceidentifier'      => 'RecordSourceIdentifier',
            'x311'                        => 'RecordSourceIDType',
            'a197'                        => 'RecordSourceName',
            'a194'                        => 'RecordSourceType',
            'b398'                        => 'RegionCode',
            'x450'                        => 'RegionsIncluded',
            'x452'                        => 'RegionsExcluded',
            'reissue'                     => 'Reissue',
            'j365'                        => 'ReissueDate',
            'j366'                        => 'ReissueDescription',
            'relatedmaterial'             => 'RelatedMaterial',
            'relatedproduct'              => 'RelatedProduct',
            'relatedwork'                 => 'RelatedWork',
            'religioustext'               => 'ReligiousText',
            'religioustextfeature'        => 'ReligiousTextFeature',
            'b359'                        => 'ReligiousTextFeatureCode',
            'b360'                        => 'ReligiousTextFeatureDescription',
            'b358'                        => 'ReligiousTextFeatureType',
            'b376'                        => 'ReligiousTextIdentifier',
            'k309'                        => 'ReprintDetail',
            'x436'                        => 'ResourceContentType',
            'resourcefeature'             => 'ResourceFeature',
            'x438'                        => 'ResourceFeatureType',
            'x441'                        => 'ResourceForm',
            'x435'                        => 'ResourceLink',
            'x437'                        => 'ResourceMode',
            'resourceversion'             => 'ResourceVersion',
            'resourceversionfeature'      => 'ResourceVersionFeature',
            'x442'                        => 'ResourceVersionFeatureType',
            'x456'                        => 'ROWSalesRightsType',
            'j269'                        => 'ReturnsCode',
            'j268'                        => 'ReturnsCodeType',
            'x460'                        => 'ReturnsCodeTypeName',
            'returnsconditions'           => 'ReturnsConditions',
            'salesrights'                 => 'SalesRights',
            'b089'                        => 'SalesRightsType',
            'salesoutlet'                 => 'SalesOutlet',
            'salesoutletidentifier'       => 'SalesOutletIdentifier',
            'b393'                        => 'SalesOutletIDType',
            'b382'                        => 'SalesOutletName',
            'salesrestriction'            => 'SalesRestriction',
            'x453'                        => 'SalesRestrictionNote',
            'b381'                        => 'SalesRestrictionType',
            'x420'                        => 'ScriptCode',
            'sender'                      => 'Sender',
            'm379'                        => 'SenderIDType',
            'senderidentifier'            => 'SenderIdentifier',
            'x298'                        => 'SenderName',
            'x307'                        => 'SentDateTime',
            'b034'                        => 'SequenceNumber',
            'x330'                        => 'SourceName',
            'x428'                        => 'SourceTitle',
            'x431'                        => 'SourceType',
            'b324'                        => 'StartDate',
            'stock'                       => 'Stock',
            'j297'                        => 'StockQuantityCode',
            'j293'                        => 'StockQuantityCodeType',
            'j296'                        => 'StockQuantityCodeTypeName',
            'stockquantitycoded'          => 'StockQuantityCoded',
            'b389'                        => 'StudyBibleType',
            'subject'                     => 'Subject',
            'b069'                        => 'SubjectCode',
            'b070'                        => 'SubjectHeadingText',
            'b067'                        => 'SubjectSchemeIdentifier',
            'b171'                        => 'SubjectSchemeName',
            'b068'                        => 'SubjectSchemeVersion',
            'b029'                        => 'Subtitle',
            'b248'                        => 'SuffixToKey',
            'supplier'                    => 'Supplier',
            'x458'                        => 'SupplierCodeType',
            'x459'                        => 'SupplierCodeValue',
            'supplieridentifier'          => 'SupplierIdentifier',
            'j345'                        => 'SupplierIDType',
            'j137'                        => 'SupplierName',
            'supplierowncoding'           => 'SupplierOwnCoding',
            'j292'                        => 'SupplierRole',
            'supplydate'                  => 'SupplyDate',
            'x461'                        => 'SupplyDateRole',
            'supplydetail'                => 'SupplyDetail',
            'supportingresource'          => 'SupportingResource',
            'tax'                         => 'Tax',
            'x474'                        => 'TaxAmount',
            'x471'                        => 'TaxRateCode',
            'x472'                        => 'TaxRatePercent',
            'x473'                        => 'TaxableAmount',
            'x470'                        => 'TaxType',
            'j270'                        => 'TelephoneNumber',
            'territory'                   => 'Territory',
            'd104'                        => 'Text',
            'd107'                        => 'TextAuthor',
            'textcontent'                 => 'TextContent',
            'textitem'                    => 'TextItem',
            'b285'                        => 'TextItemIDType',
            'textitemidentifier'          => 'TextItemIdentifier',
            'b290'                        => 'TextItemType',
            'b374'                        => 'TextSourceCorporate',
            'x426'                        => 'TextType',
            'b369'                        => 'ThesisPresentedTo',
            'b368'                        => 'ThesisType',
            'b370'                        => 'ThesisYear',
            'titledetail'                 => 'TitleDetail',
            'titleelement'                => 'TitleElement',
            'x409'                        => 'TitleElementLevel',
            'b030'                        => 'TitlePrefix',
            'b043'                        => 'TitlesAfterNames',
            'b038'                        => 'TitlesBeforeNames',
            'x478'                        => 'TitleStatement',
            'b203'                        => 'TitleText',
            'b202'                        => 'TitleType',
            'b031'                        => 'TitleWithoutPrefix',
            'x413'                        => 'ToLanguage',
            'b384'                        => 'TradeCategory',
            'b249'                        => 'UnnamedPersons',
            'j192'                        => 'UnpricedItemType',
            'website'                     => 'Website',
            'b294'                        => 'WebsiteDescription',
            'b295'                        => 'WebsiteLink',
            'b367'                        => 'WebsiteRole',
            'workidentifier'              => 'WorkIdentifier',
            'b201'                        => 'WorkIDType',
            'x454'                        => 'WorkRelationCode',
            'b020'                        => 'YearOfAnnual',
            'mainseriesrecord'            => 'MainSeriesRecord',
            'subseriesrecord'             => 'SubSeriesRecord',
            'a195'                        => 'RecordSourceIdentifierType',
            'a196'                        => 'RecordSourceIdentifier',
            'a198'                        => 'DeletionCode',
            'b004'                        => 'ISBN',
            'b005'                        => 'EAN13',
            'b006'                        => 'UPC',
            'b007'                        => 'PublisherProductNo',
            'b008'                        => 'ISMN',
            'b009'                        => 'DOI',
            'b246'                        => 'Barcode',
            'b010'                        => 'ReplacesISBN',
            'b011'                        => 'ReplacesEAN13',
            'b013'                        => 'BookFormDetail',
            'containeditem'               => 'ContainedItem',
            'b210'                        => 'NumberOfPieces',
            'b015'                        => 'ItemQuantity',
            'b211'                        => 'EpubType',
            'b212'                        => 'EpubTypeVersion',
            'b213'                        => 'EpubTypeDescription',
            'b214'                        => 'EpubFormat',
            'b215'                        => 'EpubFormatVersion',
            'b216'                        => 'EpubFormatDescription',
            'b278'                        => 'EpubSource',
            'b279'                        => 'EpubSourceVersion',
            'b280'                        => 'EpubSourceDescription',
            'b277'                        => 'EpubTypeNote',
            'series'                      => 'Series',
            'n338'                        => 'NoSeries',
            'b016'                        => 'SeriesISSN',
            'b017'                        => 'PublisherSeriesCode',
            'seriesidentifier'            => 'SeriesIdentifier',
            'b273'                        => 'SeriesIDType',
            'b018'                        => 'TitleOfSeries',
            'b019'                        => 'NumberWithinSeries',
            'set'                         => 'Set',
            'b021'                        => 'ISBNOfSet',
            'b022'                        => 'EAN13OfSet',
            'b023'                        => 'TitleOfSet',
            'b024'                        => 'SetPartNumber',
            'b025'                        => 'SetPartTitle',
            'b026'                        => 'ItemNumberWithinSet',
            'b281'                        => 'SetItemTitle',
            'b027'                        => 'TextCaseFlag',
            'b028'                        => 'DistinctiveTitle',
            'b032'                        => 'TranslationOfTitle',
            'b033'                        => 'FormerTitle',
            'title'                       => 'Title',
            'b276'                        => 'AbbreviatedLength',
            'b340'                        => 'SequenceNumberWithinRole',
            'name'                        => 'Name',
            'b250'                        => 'PersonNameType',
            'personnameidentifier'        => 'PersonNameIdentifier',
            'b390'                        => 'PersonNameIDType',
            'persondate'                  => 'PersonDate',
            'b305'                        => 'PersonDateRole',
            'b050'                        => 'ConferenceDescription',
            'b056'                        => 'EditionTypeCode',
            'b059'                        => 'LanguageOfText',
            'b060'                        => 'OriginalLanguage',
            'b254'                        => 'PagesRoman',
            'b255'                        => 'PagesArabic',
            'illustrations'               => 'Illustrations',
            'b256'                        => 'IllustrationType',
            'b361'                        => 'IllustrationTypeDescription',
            'b064'                        => 'BASICMainSubject',
            'b200'                        => 'BASICVersion',
            'b065'                        => 'BICMainSubject',
            'b066'                        => 'BICVersion',
            'mainsubject'                 => 'MainSubject',
            'b191'                        => 'MainSubjectSchemeIdentifier',
            'personassubject'             => 'PersonAsSubject',
            'b071'                        => 'CorporateBodyAsSubject',
            'b072'                        => 'PlaceAsSubject',
            'b189'                        => 'USSchoolGrade',
            'b190'                        => 'InterestAge',
            'b241'                        => 'NameCodeType',
            'b242'                        => 'NameCodeTypeName',
            'b243'                        => 'NameCodeValue',
            'b084'                        => 'CopublisherName',
            'b085'                        => 'SponsorName',
            'b240'                        => 'OriginalPublisher',
            'b086'                        => 'AnnouncementDate',
            'b362'                        => 'TradeAnnouncementDate',
            'b003'                        => 'PublicationDate',
            'b088'                        => 'YearFirstPublished',
            'notforsale'                  => 'NotForSale',
            'b090'                        => 'RightsCountry',
            'b388'                        => 'RightsTerritory',
            'b091'                        => 'RightsRegion',
            'b383'                        => 'SalesRestrictionDetail',
            'c093'                        => 'MeasureTypeCode',
            'c096'                        => 'Height',
            'c097'                        => 'Width',
            'c098'                        => 'Thickness',
            'c099'                        => 'Weight',
            'c258'                        => 'Dimensions',
            'd100'                        => 'Annotation',
            'd101'                        => 'MainDescription',
            'othertext'                   => 'OtherText',
            'd102'                        => 'TextTypeCode',
            'd103'                        => 'TextFormat',
            'd105'                        => 'TextLinkType',
            'd106'                        => 'TextLink',
            'd108'                        => 'TextSourceTitle',
            'd109'                        => 'TextPublicationDate',
            'e110'                        => 'ReviewQuote',
            'f111'                        => 'CoverImageFormatCode',
            'f112'                        => 'CoverImageLinkTypeCode',
            'f113'                        => 'CoverImageLink',
            'mediafile'                   => 'MediaFile',
            'f114'                        => 'MediaFileTypeCode',
            'f115'                        => 'MediaFileFormatCode',
            'f259'                        => 'ImageResolution',
            'f116'                        => 'MediaFileLinkTypeCode',
            'f117'                        => 'MediaFileLink',
            'f118'                        => 'TextWithDownload',
            'f119'                        => 'DownloadCaption',
            'f120'                        => 'DownloadCredit',
            'f121'                        => 'DownloadCopyrightNotice',
            'f122'                        => 'DownloadTerms',
            'f373'                        => 'MediaFileDate',
            'productwebsite'              => 'ProductWebsite',
            'f170'                        => 'ProductWebsiteDescription',
            'f123'                        => 'ProductWebsiteLink',
            'g124'                        => 'PrizesDescription',
            'h130'                        => 'ReplacedByISBN',
            'h131'                        => 'ReplacedByEAN13',
            'h208'                        => 'RelationCode',
            'h132'                        => 'AlternativeFormatISBN',
            'h133'                        => 'AlternativeFormatEAN13',
            'h163'                        => 'AlternativeProductISBN',
            'h164'                        => 'AlternativeProductEAN13',
            'h134'                        => 'OutOfPrintDate',
            'j135'                        => 'SupplierEANLocationNumber',
            'j136'                        => 'SupplierSAN',
            'j138'                        => 'SupplyToCountry',
            'j139'                        => 'SupplyToRegion',
            'j397'                        => 'SupplyToTerritory',
            'j140'                        => 'SupplyToCountryExcluded',
            'j399'                        => 'SupplyRestrictionDetail',
            'j387'                        => 'LastDateForReturns',
            'j141'                        => 'AvailabilityCode',
            'j348'                        => 'IntermediaryAvailabilityCode',
            'j142'                        => 'ExpectedShipDate',
            'j143'                        => 'OnSaleDate',
            'j146'                        => 'AudienceRestrictionFlag',
            'j147'                        => 'AudienceRestrictionNote',
            'j148'                        => 'PriceTypeCode',
            'j149'                        => 'ClassOfTrade',
            'j150'                        => 'BICDiscountGroupCode',
            'j303'                        => 'Territory',
            'j304'                        => 'CountryExcluded',
            'j308'                        => 'TerritoryExcluded',
            'j153'                        => 'TaxRateCode1',
            'j154'                        => 'TaxRatePercent1',
            'j155'                        => 'TaxableAmount1',
            'j156'                        => 'TaxAmount1',
            'j157'                        => 'TaxRateCode2',
            'j158'                        => 'TaxRatePercent2',
            'j159'                        => 'TaxableAmount2',
            'j160'                        => 'TaxAmount2',
            'j161'                        => 'PriceEffectiveFrom',
            'j162'                        => 'PriceEffectiveUntil',
            'marketrepresentation'        => 'MarketRepresentation',
            'j403'                        => 'MarketCountry',
            'j404'                        => 'MarketTerritory',
            'j405'                        => 'MarketCountryExcluded',
            'j406'                        => 'MarketRestrictionDetail',
            'a245'                        => 'SubordinateEntries',
            'parentidentifier'            => 'ParentIdentifier',
            'b282'                        => 'SeriesPartName',
            'm172'                        => 'FromEANNumber',
            'm173'                        => 'FromSAN',
            'm174'                        => 'FromCompany',
            'm175'                        => 'FromPerson',
            'm283'                        => 'FromEmail',
            'm176'                        => 'ToEANNumber',
            'm177'                        => 'ToSAN',
            'm178'                        => 'ToCompany',
            'm179'                        => 'ToPerson',
            'm182'                        => 'SentDate',
            'm185'                        => 'DefaultPriceTypeCode',
            'm187'                        => 'DefaultLinearUnit',
            'm188'                        => 'DefaultWeightUnit',
            'm193'                        => 'DefaultClassOfTrade',
        ];
    }
}
