<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class FlightBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function accessToken()
    {
        $client = new Client(); //GuzzleHttp\Client
    $result = $client->post('https://test.api.amadeus.com/v1/security/oauth2/token', [
        'headers' => [
            'Accept'     => 'application/json',
            
        ],        
        'form_params' => [
            'client_id' => getenv("CLIENT_ID"),
            'client_secret' => getenv("CLIENT_SECRET"),
            'grant_type' => 'client_credentials',
        ]
    ]);  
    
    return json_decode($result->getBody());
    }

    
    public function flightOffersSearch(Request $request)
    {
        $flightData =  [               
            'currencyCode' =>"USD",
            'originDestinations' =>[
              [
                'id' =>"1",
                'originLocationCode' =>"RIO",
                'destinationLocationCode' =>"MAD",
                'departureDateTimeRange' =>[
                  'date' =>"2021-12-21",
                  'time' =>"10:00:00",
                ],
              ],
              [
                'id' =>"2",
                'originLocationCode' =>"MAD",
                'destinationLocationCode' =>"RIO",
                'departureDateTimeRange' =>[
                  'date' =>"2021-12-22",
                  'time' =>"17:00:00",
                ],
              ],
            ],
            'travelers' =>[
              [
                'id' =>"1",
                'travelerType' =>"ADULT",
              ],
              [
                'id' =>"2",
                'travelerType' =>"CHILD",
              ],
            ],
            'sources' =>["GDS"],
            'searchCriteria' =>[
              'maxFlightOffers' =>2,
              'flightFilters' =>[
                'cabinRestrictions' =>[
                  [
                    'cabin' =>"BUSINESS",
                    'coverage' =>"MOST_SEGMENTS",
                    'originDestinationIds' =>["1"],
                  ],
                  
                ],
                'carrierRestrictions' =>[
                  'excludedCarrierCodes' =>["AA", "TP", "AZ"],
                ],
              ],
            ]
          ];

        $client = new Client(); //GuzzleHttp\Client

        // NOTE that array data should not be hard coded but come from front end request

        // You can read the documentation for Flight Offers Search at https://developers.amadeus.com/self-service/category/air/api-doc/flight-offers-search/api-reference
        
        $result = $client->post('https://test.api.amadeus.com/v2/shopping/flight-offers', [
        
            'headers' => ['Content-Type' => 'application/json','Authorization' => 'Bearer '.$request->access_token],
            
            'form_params' => [$flightData]                  
            ],                
              
        );  
    
        $result = json_decode($result->getBody());
    
        return $result;
    }
    public function flightOffersPrice(Request $request)
    {
        $client = new Client(); //GuzzleHttp\Client

        // NOTE that array data should not be hard coded but come from front end request
    
        // You can read the documentation for Flight Offers Price at https://developers.amadeus.com/self-service/category/air/api-doc/flight-offers-price/api-reference

        $result = $client->post('https://test.api.amadeus.com/v1/shopping/flight-offers/pricing', [
        
            'headers' => ['Content-Type' => 'application/json','Authorization' => 'Bearer '.$request->access_token],
            
            'form_params' => [
                'data' => [
                  'type' => 'flight-offers-pricing',
                  'flightOffers' => [
                    0 => [
                      'type' => 'flight-offer',
                      'id' => '1',
                      'source' => 'GDS',
                      'instantTicketingRequired' => false,
                      'nonHomogeneous' => false,
                      'oneWay' => false,
                      'lastTicketingDate' => '2021-12-22',
                      'numberOfBookableSeats' => 9,
                      'itineraries' => [
                        0 => [
                          'duration' => 'PT32H15M',
                          'segments' => [
                            0 => [
                              'departure' => [
                                'iataCode' => 'SYD',
                                'terminal' => '1',
                                'at' => '2021-02-01T19:15:00',
                              ],
                              'arrival' => [
                                'iataCode' => 'SIN',
                                'terminal' => '1',
                                'at' => '2021-02-02T00:30:00',
                              ],
                              'carrierCode' => 'TR',
                              'number' => '13',
                              'aircraft' => [
                                'code' => '789',
                              ],
                              'operating' => [
                                'carrierCode' => 'TR',
                              ],
                              'duration' => 'PT8H15M',
                              'id' => '1',
                              'numberOfStops' => 0,
                              'blacklistedInEU' => false,
                            ],
                            1 => [
                              'departure' => [
                                'iataCode' => 'SIN',
                                'terminal' => '1',
                                'at' => '2021-02-02T22:05:00',
                              ],
                              'arrival' => [
                                'iataCode' => 'DMK',
                                'terminal' => '1',
                                'at' => '2021-02-02T23:30:00',
                              ],
                              'carrierCode' => 'TR',
                              'number' => '868',
                              'aircraft' => [
                                'code' => '788',
                              ],
                              'operating' => [
                                'carrierCode' => 'TR',
                              ],
                              'duration' => 'PT2H25M',
                              'id' => '2',
                              'numberOfStops' => 0,
                              'blacklistedInEU' => false,
                            ],
                          ],
                        ],
                        1 => [
                          'duration' => 'PT15H',
                          'segments' => [
                            0 => [
                              'departure' => [
                                'iataCode' => 'DMK',
                                'terminal' => '1',
                                'at' => '2021-02-05T23:15:00',
                              ],
                              'arrival' => [
                                'iataCode' => 'SIN',
                                'terminal' => '1',
                                'at' => '2021-02-06T02:50:00',
                              ],
                              'carrierCode' => 'TR',
                              'number' => '867',
                              'aircraft' => [
                                'code' => '788',
                              ],
                              'operating' => [
                                'carrierCode' => 'TR',
                              ],
                              'duration' => 'PT2H35M',
                              'id' => '5',
                              'numberOfStops' => 0,
                              'blacklistedInEU' => false,
                            ],
                            1 => [
                              'departure' => [
                                'iataCode' => 'SIN',
                                'terminal' => '1',
                                'at' => '2021-02-06T06:55:00',
                              ],
                              'arrival' => [
                                'iataCode' => 'SYD',
                                'terminal' => '1',
                                'at' => '2021-02-06T18:15:00',
                              ],
                              'carrierCode' => 'TR',
                              'number' => '12',
                              'aircraft' => [
                                'code' => '789',
                              ],
                              'operating' => [
                                'carrierCode' => 'TR',
                              ],
                              'duration' => 'PT8H20M',
                              'id' => '6',
                              'numberOfStops' => 0,
                              'blacklistedInEU' => false,
                            ],
                          ],
                        ],
                      ],
                      'price' => [
                        'currency' => 'EUR',
                        'total' => '546.70',
                        'base' => '334.00',
                        'fees' => [
                          0 => [
                            'amount' => '0.00',
                            'type' => 'SUPPLIER',
                          ],
                          1 => [
                            'amount' => '0.00',
                            'type' => 'TICKETING',
                          ],
                        ],
                        'grandTotal' => '546.70',
                      ],
                      'pricingOptions' => [
                        'fareType' => [
                          0 => 'PUBLISHED',
                        ],
                        'includedCheckedBagsOnly' => true,
                      ],
                      'validatingAirlineCodes' => [
                        0 => 'HR',
                      ],
                      'travelerPricings' => [
                        0 => [
                          'travelerId' => '1',
                          'fareOption' => 'STANDARD',
                          'travelerType' => 'ADULT',
                          'price' => [
                            'currency' => 'EUR',
                            'total' => '546.70',
                            'base' => '334.00',
                          ],
                          'fareDetailsBySegment' => [
                            0 => [
                              'segmentId' => '1',
                              'cabin' => 'ECONOMY',
                              'fareBasis' => 'O2TR24',
                              'class' => 'O',
                              'includedCheckedBags' => [
                                'weight' => 20,
                                'weightUnit' => 'KG',
                              ],
                            ],
                            1 => [
                              'segmentId' => '2',
                              'cabin' => 'ECONOMY',
                              'fareBasis' => 'O2TR24',
                              'class' => 'O',
                              'includedCheckedBags' => [
                                'weight' => 20,
                                'weightUnit' => 'KG',
                              ],
                            ],
                            2 => [
                              'segmentId' => '5',
                              'cabin' => 'ECONOMY',
                              'fareBasis' => 'X2TR24',
                              'class' => 'X',
                              'includedCheckedBags' => [
                                'weight' => 20,
                                'weightUnit' => 'KG',
                              ],
                            ],
                            3 => [
                              'segmentId' => '6',
                              'cabin' => 'ECONOMY',
                              'fareBasis' => 'H2TR24',
                              'class' => 'H',
                              'includedCheckedBags' => [
                                'weight' => 20,
                                'weightUnit' => 'KG',
                              ],
                            ],
                          ],
                        ],
                      ],
                    ],
                  ],
                ],
              ],
                
              ]
        );  
    
        $result = json_decode($result->getBody());
    
        return $result;
    }
    public function flightCreateOrders(Request $request)
    {
        $flightOrder = [
            'data' => [
              'type' => 'flight-order',
              'flightOffers' => [
                0 => [
                  'type' => 'flight-offer',
                  'id' => '1',
                  'source' => 'GDS',
                  'instantTicketingRequired' => false,
                  'nonHomogeneous' => false,
                  'paymentCardRequired' => false,
                  'lastTicketingDate' => '2020-03-01',
                  'itineraries' => [
                    0 => [
                      'segments' => [
                        0 => [
                          'departure' => [
                            'iataCode' => 'GIG',
                            'terminal' => '2',
                            'at' => '2020-03-01T21:05:00',
                          ],
                          'arrival' => [
                            'iataCode' => 'CDG',
                            'terminal' => '2E',
                            'at' => '2020-03-02T12:20:00',
                          ],
                          'carrierCode' => 'KL',
                          'number' => '2410',
                          'aircraft' => [
                            'code' => '772',
                          ],
                          'operating' => [
                            'carrierCode' => 'AF',
                          ],
                          'duration' => 'PT11H15M',
                          'id' => '40',
                          'numberOfStops' => 0,
                        ],
                        1 => [
                          'departure' => [
                            'iataCode' => 'CDG',
                            'terminal' => '2F',
                            'at' => '2020-03-02T14:30:00',
                          ],
                          'arrival' => [
                            'iataCode' => 'AMS',
                            'at' => '2020-03-02T15:45:00',
                          ],
                          'carrierCode' => 'KL',
                          'number' => '1234',
                          'aircraft' => [
                            'code' => '73H',
                          ],
                          'operating' => [
                            'carrierCode' => 'KL',
                          ],
                          'duration' => 'PT1H15M',
                          'id' => '41',
                          'numberOfStops' => 0,
                        ],
                        2 => [
                          'departure' => [
                            'iataCode' => 'AMS',
                            'at' => '2020-03-02T17:05:00',
                          ],
                          'arrival' => [
                            'iataCode' => 'MAD',
                            'terminal' => '2',
                            'at' => '2020-03-02T19:35:00',
                          ],
                          'carrierCode' => 'KL',
                          'number' => '1705',
                          'aircraft' => [
                            'code' => '73J',
                          ],
                          'operating' => [
                            'carrierCode' => 'KL',
                          ],
                          'duration' => 'PT2H30M',
                          'id' => '42',
                          'numberOfStops' => 0,
                        ],
                      ],
                    ],
                    1 => [
                      'segments' => [
                        0 => [
                          'departure' => [
                            'iataCode' => 'MAD',
                            'terminal' => '2',
                            'at' => '2020-03-05T20:25:00',
                          ],
                          'arrival' => [
                            'iataCode' => 'AMS',
                            'at' => '2020-03-05T23:00:00',
                          ],
                          'carrierCode' => 'KL',
                          'number' => '1706',
                          'aircraft' => [
                            'code' => '73J',
                          ],
                          'operating' => [
                            'carrierCode' => 'KL',
                          ],
                          'duration' => 'PT2H35M',
                          'id' => '81',
                          'numberOfStops' => 0,
                        ],
                        1 => [
                          'departure' => [
                            'iataCode' => 'AMS',
                            'at' => '2020-03-06T10:40:00',
                          ],
                          'arrival' => [
                            'iataCode' => 'GIG',
                            'terminal' => '2',
                            'at' => '2020-03-06T18:35:00',
                          ],
                          'carrierCode' => 'KL',
                          'number' => '705',
                          'aircraft' => [
                            'code' => '772',
                          ],
                          'operating' => [
                            'carrierCode' => 'KL',
                          ],
                          'duration' => 'PT11H55M',
                          'id' => '82',
                          'numberOfStops' => 0,
                        ],
                      ],
                    ],
                  ],
                  'price' => [
                    'currency' => 'USD',
                    'total' => '8514.96',
                    'base' => '8314.00',
                    'fees' => [
                      0 => [
                        'amount' => '0.00',
                        'type' => 'SUPPLIER',
                      ],
                      1 => [
                        'amount' => '0.00',
                        'type' => 'TICKETING',
                      ],
                      2 => [
                        'amount' => '0.00',
                        'type' => 'FORM_OF_PAYMENT',
                      ],
                    ],
                    'grandTotal' => '8514.96',
                    'billingCurrency' => 'USD',
                  ],
                  'pricingOptions' => [
                    'fareType' => [
                      0 => 'PUBLISHED',
                    ],
                    'includedCheckedBagsOnly' => true,
                  ],
                  'validatingAirlineCodes' => [
                    0 => 'AF',
                  ],
                  'travelerPricings' => [
                    0 => [
                      'travelerId' => '1',
                      'fareOption' => 'STANDARD',
                      'travelerType' => 'ADULT',
                      'price' => [
                        'currency' => 'USD',
                        'total' => '4849.48',
                        'base' => '4749.00',
                        'taxes' => [
                          0 => [
                            'amount' => '31.94',
                            'code' => 'BR',
                          ],
                          1 => [
                            'amount' => '14.68',
                            'code' => 'CJ',
                          ],
                          2 => [
                            'amount' => '5.28',
                            'code' => 'FR',
                          ],
                          3 => [
                            'amount' => '17.38',
                            'code' => 'JD',
                          ],
                          4 => [
                            'amount' => '0.69',
                            'code' => 'OG',
                          ],
                          5 => [
                            'amount' => '3.95',
                            'code' => 'QV',
                          ],
                          6 => [
                            'amount' => '12.12',
                            'code' => 'QX',
                          ],
                          7 => [
                            'amount' => '14.44',
                            'code' => 'RN',
                          ],
                        ],
                      ],
                      'fareDetailsBySegment' => [
                        0 => [
                          'segmentId' => '40',
                          'cabin' => 'BUSINESS',
                          'fareBasis' => 'CFFBR',
                          'brandedFare' => 'BUSINESS',
                          'class' => 'C',
                          'includedCheckedBags' => [
                            'quantity' => 2,
                          ],
                        ],
                        1 => [
                          'segmentId' => '41',
                          'cabin' => 'BUSINESS',
                          'fareBasis' => 'CFFBR',
                          'brandedFare' => 'BUSINESS',
                          'class' => 'J',
                          'includedCheckedBags' => [
                            'quantity' => 2,
                          ],
                        ],
                        2 => [
                          'segmentId' => '42',
                          'cabin' => 'BUSINESS',
                          'fareBasis' => 'CFFBR',
                          'brandedFare' => 'BUSINESS',
                          'class' => 'J',
                          'includedCheckedBags' => [
                            'quantity' => 2,
                          ],
                        ],
                        3 => [
                          'segmentId' => '81',
                          'cabin' => 'ECONOMY',
                          'fareBasis' => 'YFFBR',
                          'brandedFare' => 'FULLFLEX',
                          'class' => 'Y',
                          'includedCheckedBags' => [
                            'quantity' => 1,
                          ],
                        ],
                        4 => [
                          'segmentId' => '82',
                          'cabin' => 'ECONOMY',
                          'fareBasis' => 'YFFBR',
                          'brandedFare' => 'FULLFLEX',
                          'class' => 'Y',
                          'includedCheckedBags' => [
                            'quantity' => 1,
                          ],
                        ],
                      ],
                    ],
                    1 => [
                      'travelerId' => '2',
                      'fareOption' => 'STANDARD',
                      'travelerType' => 'CHILD',
                      'price' => [
                        'currency' => 'USD',
                        'total' => '3665.48',
                        'base' => '3565.00',
                        'taxes' => [
                          0 => [
                            'amount' => '31.94',
                            'code' => 'BR',
                          ],
                          1 => [
                            'amount' => '14.68',
                            'code' => 'CJ',
                          ],
                          2 => [
                            'amount' => '5.28',
                            'code' => 'FR',
                          ],
                          3 => [
                            'amount' => '17.38',
                            'code' => 'JD',
                          ],
                          4 => [
                            'amount' => '0.69',
                            'code' => 'OG',
                          ],
                          5 => [
                            'amount' => '3.95',
                            'code' => 'QV',
                          ],
                          6 => [
                            'amount' => '12.12',
                            'code' => 'QX',
                          ],
                          7 => [
                            'amount' => '14.44',
                            'code' => 'RN',
                          ],
                        ],
                      ],
                      'fareDetailsBySegment' => [
                        0 => [
                          'segmentId' => '40',
                          'cabin' => 'BUSINESS',
                          'fareBasis' => 'CFFBR',
                          'brandedFare' => 'BUSINESS',
                          'class' => 'C',
                          'includedCheckedBags' => [
                            'quantity' => 2,
                          ],
                        ],
                        1 => [
                          'segmentId' => '41',
                          'cabin' => 'BUSINESS',
                          'fareBasis' => 'CFFBR',
                          'brandedFare' => 'BUSINESS',
                          'class' => 'J',
                          'includedCheckedBags' => [
                            'quantity' => 2,
                          ],
                        ],
                        2 => [
                          'segmentId' => '42',
                          'cabin' => 'BUSINESS',
                          'fareBasis' => 'CFFBR',
                          'brandedFare' => 'BUSINESS',
                          'class' => 'J',
                          'includedCheckedBags' => [
                            'quantity' => 2,
                          ],
                        ],
                        3 => [
                          'segmentId' => '81',
                          'cabin' => 'ECONOMY',
                          'fareBasis' => 'YFFBR',
                          'brandedFare' => 'FULLFLEX',
                          'class' => 'Y',
                          'includedCheckedBags' => [
                            'quantity' => 1,
                          ],
                        ],
                        4 => [
                          'segmentId' => '82',
                          'cabin' => 'ECONOMY',
                          'fareBasis' => 'YFFBR',
                          'brandedFare' => 'FULLFLEX',
                          'class' => 'Y',
                          'includedCheckedBags' => [
                            'quantity' => 1,
                          ],
                        ],
                      ],
                    ],
                  ],
                ],
              ],
              'travelers' => [
                0 => [
                  'id' => '1',
                  'dateOfBirth' => '1982-01-16',
                  'name' => [
                    'firstName' => 'JORGE',
                    'lastName' => 'GONZALES',
                  ],
                  'gender' => 'MALE',
                  'contact' => [
                    'emailAddress' => 'jorge.gonzales833@telefonica.es',
                    'phones' => [
                      0 => [
                        'deviceType' => 'MOBILE',
                        'countryCallingCode' => '34',
                        'number' => '480080076',
                      ],
                    ],
                  ],
                  'documents' => [
                    0 => [
                      'documentType' => 'PASSPORT',
                      'birthPlace' => 'Madrid',
                      'issuanceLocation' => 'Madrid',
                      'issuanceDate' => '2015-04-14',
                      'number' => '00000000',
                      'expiryDate' => '2025-04-14',
                      'issuanceCountry' => 'ES',
                      'validityCountry' => 'ES',
                      'nationality' => 'ES',
                      'holder' => true,
                    ],
                  ],
                ],
                1 => [
                  'id' => '2',
                  'dateOfBirth' => '2012-10-11',
                  'gender' => 'FEMALE',
                  'contact' => [
                    'emailAddress' => 'jorge.gonzales833@telefonica.es',
                    'phones' => [
                      0 => [
                        'deviceType' => 'MOBILE',
                        'countryCallingCode' => '34',
                        'number' => '480080076',
                      ],
                    ],
                  ],
                  'name' => [
                    'firstName' => 'ADRIANA',
                    'lastName' => 'GONZALES',
                  ],
                ],
              ],
              'remarks' => [
                'general' => [
                  0 => [
                    'subType' => 'GENERAL_MISCELLANEOUS',
                    'text' => 'ONLINE BOOKING FROM INCREIBLE VIAJES',
                  ],
                ],
              ],
              'ticketingAgreement' => [
                'option' => 'DELAY_TO_CANCEL',
                'delay' => '6D',
              ],
              'contacts' => [
                0 => [
                  'addresseeName' => [
                    'firstName' => 'PABLO',
                    'lastName' => 'RODRIGUEZ',
                  ],
                  'companyName' => 'INCREIBLE VIAJES',
                  'purpose' => 'STANDARD',
                  'phones' => [
                    0 => [
                      'deviceType' => 'LANDLINE',
                      'countryCallingCode' => '34',
                      'number' => '480080071',
                    ],
                    1 => [
                      'deviceType' => 'MOBILE',
                      'countryCallingCode' => '33',
                      'number' => '480080072',
                    ],
                  ],
                  'emailAddress' => 'support@increibleviajes.es',
                  'address' => [
                    'lines' => [
                      0 => 'Calle Prado, 16',
                    ],
                    'postalCode' => '28014',
                    'cityName' => 'Madrid',
                    'countryCode' => 'ES',
                  ],
                ],
              ],
            ],
        ];

        $client = new Client(); //GuzzleHttp\Client

        // NOTE that array data should not be hard coded but come from front end request

        // You can read the documentation for Flight Create Orders at https://developers.amadeus.com/self-service/category/air/api-doc/flight-create-orders/api-reference

        
        $result = $client->post('https://test.api.amadeus.com/v1/booking/flight-orders', [
        
            'headers' => ['Content-Type' => 'application/json','Authorization' => 'Bearer '.$request->access_token],
            
            'form_params' => [$flightOrder]                  
            ],                
              
        );  
    
        $result = json_decode($result->getBody());
    
        return $result;
    }
    
}
