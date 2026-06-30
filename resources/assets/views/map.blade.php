<script type="text/javascript">

	console.log(window.contid+" <<<<=== "+window.maplevel);
	
	function zoomToFeature(e) {
		map.removeLayer(geojson);

		var geojson2;

		
	var geojson2 = new L.GeoJSON(countriesData, {
			style: function(feature) {
				return {fillColor: 'white', color: 'blue', weight: 0.5,  stroke: 0.7, fillOpacity: 0.8};
			},
			// onEachFeature: function(feature, marker) {
			//     marker.bindPopup('Name : '+feature.properties.Name+' ('+ feature.properties.DB_ID+')');
			// }
			onEachFeature: onEachFeature2
		});

	map.addLayer(geojson2);

	L.tileLayer('https://api.maptiler.com/maps/basic/256/{z}/{x}/{y}.png?key=088HTkVkumk1ZGlBjdvX', {
			maxZoom: 4,
			minZoom: 1,
			attribution: '',
			id: 'mapbox.light'
		}).addTo(map);

		// map.fitBounds(geojson2.getBounds());
		map.setView([41.771312,8.684994], 1);

	var searchControl2 = new L.Control.Search({
		layer: geojson2,
		propertyName: 'Name',
		marker: false,
		moveToLocation: function(latlng, title, map) {
			//map.fitBounds( latlng.layer.getBounds() );
			var zoom = map.getBoundsZoom(latlng.layer.getBounds());
			map.setView(latlng, zoom); // access the zoom
		}
	});

	searchControl2.on('search:locationfound', function(e) {
		e.layer.setStyle({fillColor: 'blue', color: 'black', weight: 0.5,  stroke: 0.7, fillOpacity: 0.8});
		if(e.layer._popup)
			e.layer.openPopup();
	}).on('search:collapsed', function(e) {
		// geojson2.eachLayer(function(layer) {   //restore feature color
		//     geojson2.resetStyle(layer);
		// }); 
	});

	//console.log(map.hasLayer(geojson2)+" <<<====");
	map.addControl(searchControl2);  //inizialize search control

	



///// Starts Back button1

var backbut1 = L.easyButton({
position: 'topright',
states:[
{
	stateName: 'globe-layer',
	icon: 'fa-arrow-left',
	title: 'globe',
	onClick: function(control) {
		//console.log(control);
		map.removeLayer(geojson2);
		searchControl2.remove();
		geojson.addTo(map);
		map.setView([41.771312,8.684994], 1);
		backbut1.remove();

	}	
}
]
});

map.addControl(backbut1);

///// Ends Back button1

		function onEachFeature2(feature2, layer2) {
			layer2.on({
				mouseover: highlightFeature2,
				mouseout: resetHighlight2,
				dblclick: zoomToFeature2
			});
		}

		function highlightFeature2(e) {
			var layer2 = e.target;

			layer2.setStyle({
				fillColor: 'red',
				fillOpacity: 0.5,
				color: "blue",
				weight: 0.7,
				opacity: 0.5,
				stroke: 0.1,
				dashArray: '0'
			});


			if (!L.Browser.ie && !L.Browser.opera) {
				layer2.bringToFront();
			}

			info.update(layer2.feature.properties);
		}

		function resetHighlight2(e) {
			geojson2.resetStyle(e.target);
			info.update();
		}

		function zoomToFeature2(e) {

			console.log(window.contid+" <<<<=== "+window.maplevel);

			//e.target.setStyle({fillColor: 'blue', color: 'black', weight: 0.5,  stroke: 0.7, fillOpacity: 0.8});

////////// Starts India Level Code 1

			if (window.contid == 1 && window.maplevel == 0) {

					map.removeLayer(geojson2);
					map.removeControl(searchControl2); 

					load('./maps/KML/1/O_1.js');

					maplevel = 1; 

		// var piecht1 = L.piechartMarker(
		// //L.latLng(latLng),
		// L.latLng([21.861499,78.695625]),
		//     {
		//     radius: 50,
		//         data: [
		//             { name: 'Apples', value: 25, style: { fillStyle: 'red', lineWidth: 1 } },
		//             { name: 'Oranges', value: 35, style: { fillStyle: 'blue', lineWidth: 1 } },
		//             { name: 'Bananas', value: 20, style: { fillStyle: 'black', lineWidth: 1 } },
		//             { name: 'Pineapples', value: 30, style: { fillStyle: 'green', lineWidth: 1 } },
		//             { name: 'Fig', value: 70, style: { fillStyle: 'violet', lineWidth: 1 } }
		//             //{ name: 'Fig', value: 70, style: { fillStyle: 'rgba(0,127,0,.6)', strokeStyle: 'rgba(0,127,0,.95)', lineWidth: 10 } }
		//         ]
		//     }
		// );
		// piecht1.addTo(map);

					var geojson3;

					var geojson3 = new L.GeoJSON(O_1, {
						style: function(feature) {
							return {fillColor: 'white', color: 'blue', weight: 0.5,  stroke: 0.7, fillOpacity: 0.8};
						},
						onEachFeature: onEachFeature3
					});

					map.addLayer(geojson3);


					L.tileLayer('https://api.maptiler.com/maps/basic/256/{z}/{x}/{y}.png?key=088HTkVkumk1ZGlBjdvX', {
						maxZoom: 6,
						minZoom: 1,
						attribution: '',
						id: 'mapbox.light'
					}).addTo(map);

					// map.fitBounds(geojson3.getBounds());
					map.setView([24.910353,79.719117], 4);

					var searchControl3 = new L.Control.Search({
						layer: geojson3,
						propertyName: 'Name',
						marker: false,
						moveToLocation: function(latlng, title, map) {
							//map.fitBounds( latlng.layer.getBounds() );
							var zoom = map.getBoundsZoom(latlng.layer.getBounds());
							map.setView(latlng, zoom); // access the zoom
						}
					});

					searchControl3.on('search:locationfound', function(e) {
						e.layer.setStyle({fillColor: 'blue', color: 'black', weight: 0.5,  stroke: 0.7, fillOpacity: 0.8});
						if(e.layer._popup)
							e.layer.openPopup();
					}).on('search:collapsed', function(e) {

						geojson3.eachLayer(function(layer) {   //restore feature color
							geojson3.resetStyle(layer);
						}); 
					});
					
					map.addControl(searchControl3);  //inizialize search control
					

///// Starts Back button2

backbut1.remove();

var backbut2 = L.easyButton({
position: 'topright',
states:[
{
	stateName: 'countries-layer',
	icon: 'fa-arrow-left',
	title: 'countries',
	id: 'countriesLayer',
	onClick: function(control) {
		//console.log(control);
		map.removeLayer(geojson3);
		searchControl3.remove();
		geojson2.addTo(map);
		map.addControl(searchControl2);
		window.maplevel = 0;
		map.setView([41.771312,8.684994], 1);
		backbut2.remove();
		// piecht1.remove();
		$('.cokLabel').hide();
		map.addControl(backbut1);
		
	}	
}
]
});

map.addControl(backbut2);

///// Ends Back button2

// var bounds = geojson3.getBounds();
// var latLng = bounds.getCenter();


//   var legend = L.control({position: 'bottomleft'});

//         legend.onAdd = function (map) {

//         	var div = L.DomUtil.create('div', 'info legend'),
//         		grades = [100, 200, 500, 1000],
//         		labels = ['Apples', 'Oranges', 'AAAA', 'BBBBB'],
//         		from, to;

//         	for (var i = 0; i < grades.length; i++) {
//         		from = grades[i];
//         		to = grades[i + 1];

//         		labels.push(
//         			'<i style="background: red"></i> ' +
//         			from + (to ? '&ndash;' + to : '+'));
//         	}

//         	div.innerHTML = labels.join('<br>');
//         	return div;
//         };

//         legend.addTo(map);

					function onEachFeature3(feature3, layer3) {
						layer3.on({
							mouseover: highlightFeature3,
							mouseout: resetHighlight3,
							dblclick: zoomToFeature3
						});

						var label = L.marker([36.102376,74.166826], {
								icon: L.divIcon({
									className: 'cokLabel',
									html: "<span style='color:grey;'>POK</span>",
									iconSize: [0, 0]
								})
						}).addTo(map);

						var label = L.marker([35.398006,78.487318], {
								icon: L.divIcon({
									className: 'cokLabel',
									html: "<span style='color:grey;'>COK</span>",
									iconSize: [0, 0]
								})
						}).addTo(map);
					}

					function highlightFeature3(e) {
						var layer3 = e.target;

						layer3.setStyle({
							fillColor: 'red',
							fillOpacity: 0.5,
							color: "blue",
							weight: 0.7,
							opacity: 0.5,
							stroke: 0.1,
							dashArray: '0'
						});


						if (!L.Browser.ie && !L.Browser.opera) {
							layer3.bringToFront();
						}

						info.update(layer3.feature.properties);
					}

					function resetHighlight3(e) {
						geojson3.resetStyle(e.target);
						info.update();
					}



					function zoomToFeature3(e) {

						map.removeLayer(geojson3);
						map.removeControl(searchControl3); 

						load('./maps/KML/1/S_1.js');

						var geojson4;

						var geojson4 = new L.GeoJSON(S_1, {
								style: function(feature) {
									return {fillColor: 'white', color: 'blue', weight: 0.5,  stroke: 0.7, fillOpacity: 0.8};
								},
								// onEachFeature: function(feature, marker) {
								//     marker.bindPopup('Name : '+feature.properties.Name+' ('+ feature.properties.DB_ID+')');
								// }
								onEachFeature: onEachFeature4
							});
						
						L.tileLayer('https://api.maptiler.com/maps/basic/256/{z}/{x}/{y}.png?key=088HTkVkumk1ZGlBjdvX', {
							maxZoom: 5,
							minZoom: 1,
							attribution: '',
							id: 'mapbox.light'
						}).addTo(map);

						// map.fitBounds(geojson4.getBounds());

						var searchControl4 = new L.Control.Search({
							layer: geojson4,
							propertyName: 'Name',
							marker: false,
							moveToLocation: function(latlng, title, map) {
								//map.fitBounds( latlng.layer.getBounds() );
								var zoom = map.getBoundsZoom(latlng.layer.getBounds());
								map.setView(latlng, zoom); // access the zoom
							}
						});

						searchControl4.on('search:locationfound', function(e) {
							e.layer.setStyle({fillColor: 'blue', color: 'black', weight: 0.5,  stroke: 0.7, fillOpacity: 0.8});
							if(e.layer._popup)
								e.layer.openPopup();
						}).on('search:collapsed', function(e) {

							geojson4.eachLayer(function(layer) {   //restore feature color
								geojson4.resetStyle(layer);
							}); 
						});
						
						map.addControl(searchControl4);  //inizialize search control


///// Starts Back button3
backbut2.remove();

var backbut3 = L.easyButton({
position: 'topright',
states:[
{
	stateName: 'states-layer',
	icon: 'fa-arrow-left',
	title: 'states',
	id: 'statesLayer',
		onClick: function(control) {
		//   console.log(control);
			map.removeLayer(geojson4);
			searchControl4.remove();
			geojson3.addTo(map);
			map.addControl(searchControl3);
			map.fitBounds(geojson3.getBounds());
			backbut3.remove();
			map.addControl(backbut2);
			
		}	
}
]
});

map.addControl(backbut3);
///// Ends Back button3


						function onEachFeature4(feature4, layer4) {
							layer4.on({
								mouseover: highlightFeature4,
								mouseout: resetHighlight4,
								dblclick: zoomToFeature4
							});
						}

						function highlightFeature4(e) {
							var layer4 = e.target;

							layer4.setStyle({
								fillColor: 'red',
								fillOpacity: 0.5,
								color: "blue",
								weight: 0.7,
								opacity: 0.5,
								stroke: 0.1,
								dashArray: '0'
							});


							if (!L.Browser.ie && !L.Browser.opera) {
								layer4.bringToFront();
							}

							info.update(layer4.feature.properties);
						}

						function resetHighlight4(e) {
							geojson4.resetStyle(e.target);
							info.update();
						}



						function zoomToFeature4(e) {

							map.removeLayer(geojson4);
							map.removeControl(searchControl4); 
							$('.cokLabel').hide();

///// Starts India ==> Karnataka (17)
							window.maplevel = 2;

							var distid2 = parseInt(window.contid);

							file_info4 = './maps/KML/1/'+distid2+'/O_'+distid2+'.js';
							//file_info2 = './maps/KML/1/21/O_21.js';
							load(file_info4);

							var myVariable4 = 'O_'+distid2;
							console.log(file_info4+" <<<=== "+myVariable4);

							var geojson5;

							var geojson5 = new L.GeoJSON(eval(myVariable4), {
								style: function(feature) {
									return {fillColor: 'white', color: 'blue', weight: 0.5,  stroke: 0.7, fillOpacity: 0.8};
								},
								// onEachFeature: function(feature, marker) {
								//     marker.bindPopup('Name : '+feature.properties.Name+' ('+ feature.properties.DB_ID+')');
								// }
								onEachFeature: onEachFeature5
							});

							L.tileLayer('https://api.maptiler.com/maps/basic/256/{z}/{x}/{y}.png?key=088HTkVkumk1ZGlBjdvX', {
								maxZoom: 7,
								minZoom: 1,
								attribution: '',
								id: 'mapbox.light'
							}).addTo(map);

							map.fitBounds(geojson5.getBounds());

							var searchControl5 = new L.Control.Search({
								layer: geojson5,
								propertyName: 'Name',
								marker: false,
								moveToLocation: function(latlng, title, map) {
									//map.fitBounds( latlng.layer.getBounds() );
									var zoom = map.getBoundsZoom(latlng.layer.getBounds());
									map.setView(latlng, zoom); // access the zoom
								}
							});

							searchControl5.on('search:locationfound', function(e) {
								e.layer.setStyle({fillColor: 'blue', color: 'black', weight: 0.5,  stroke: 0.7, fillOpacity: 0.8});
								if(e.layer._popup)
									e.layer.openPopup();
							}).on('search:collapsed', function(e) {
								geojson5.eachLayer(function(layer) {   //restore feature color
									geojson5.resetStyle(layer);
								}); 
							});
							
							map.addControl(searchControl5);  //inizialize search control



backbut3.remove();

var backbut4 = L.easyButton({
position: 'topright',
states:[
	{
		stateName: 'states-layer',
		icon: 'fa-arrow-left',
		title: 'states',
		id: 'statesLayer',
		onClick: function(control) {
			//console.log(control);
			map.removeLayer(geojson5);
			searchControl5.remove();
			geojson4.addTo(map);
			map.addControl(searchControl4);
			map.fitBounds(geojson4.getBounds());

			backbut4.remove();
			$('.cokLabel').hide();
			map.addControl(backbut3);
			
		}	
	}
]
});

map.addControl(backbut4);





									function onEachFeature5(feature5, layer5) {
										layer5.on({
											mouseover: highlightFeature5,
											mouseout: resetHighlight5,
											dblclick: zoomToFeature5
										});
									}

									function highlightFeature5(e) {
										var layer5 = e.target;

										layer5.setStyle({
											fillColor: 'red',
											fillOpacity: 0.5,
											color: "blue",
											weight: 0.7,
											opacity: 0.5,
											stroke: 0.1,
											dashArray: '0'
										});


										if (!L.Browser.ie && !L.Browser.opera) {
											layer5.bringToFront();
										}

										info.update(layer5.feature.properties);
									}

									function resetHighlight5(e) {
										geojson5.resetStyle(e.target);
										info.update();
									}

									function zoomToFeature5(e) {
										map.removeLayer(geojson5);
										map.removeControl(searchControl5); 

										file_info5 = './maps/KML/1/'+distid2+'/D_'+distid2+'.js';
										
										load(file_info5);
										var myVariable5 = 'D_'+distid2;
										console.log(file_info5+ "  "+myVariable5);

										var geojson6;
										var geojson6 = new L.GeoJSON(eval(myVariable5), {
											style: function(feature) {
												return {fillColor: 'white', color: 'blue', weight: 0.5,  stroke: 0.7, fillOpacity: 0.8};
											},
											// onEachFeature: function(feature, marker) {
											//     marker.bindPopup('Name : '+feature.properties.Name+' ('+ feature.properties.DB_ID+')');
											// }
											onEachFeature: onEachFeature6
										});

										L.tileLayer('https://api.maptiler.com/maps/basic/256/{z}/{x}/{y}.png?key=088HTkVkumk1ZGlBjdvX', {
											maxZoom: 9,
											minZoom: 1,
											attribution: '',
											id: 'mapbox.light'
										}).addTo(map);

										// map.fitBounds(geojson6.getBounds());

										var searchControl6 = new L.Control.Search({
											layer: geojson6,
											propertyName: 'Name',
											marker: false,
											moveToLocation: function(latlng, title, map) {
												//map.fitBounds( latlng.layer.getBounds() );
												var zoom = map.getBoundsZoom(latlng.layer.getBounds());
												map.setView(latlng, zoom); // access the zoom
											}
										});

										searchControl6.on('search:locationfound', function(e) {
											e.layer.setStyle({fillColor: 'blue', color: 'black', weight: 0.5,  stroke: 0.7, fillOpacity: 0.8});
											if(e.layer._popup)
												e.layer.openPopup();
										}).on('search:collapsed', function(e) {
											geojson6.eachLayer(function(layer) {   //restore feature color
												geojson6.resetStyle(layer);
											}); 
										});
										
										map.addControl(searchControl6);  //inizialize search control



backbut4.remove();

var backbut5 = L.easyButton({
position: 'topright',
states:[
{
	stateName: 'states-layer',
	icon: 'fa-arrow-left',
	title: 'states',
	id: 'statesLayer',
	onClick: function(control) {
			//console.log(control);
		map.removeLayer(geojson6);
		searchControl6.remove();
		geojson5.addTo(map);
		map.addControl(searchControl5);
		map.fitBounds(geojson5.getBounds());
		backbut5.remove();
		map.addControl(backbut4);
		
	}	
}
]
});

											map.addControl(backbut5);




										function onEachFeature6(feature6, layer6) {
											layer6.on({
												mouseover: highlightFeature6,
												mouseout: resetHighlight6,
												dblclick: zoomToFeature6
											});
										}

										function highlightFeature6(e) {
											var layer6 = e.target;

											layer6.setStyle({
												fillColor: 'red',
												fillOpacity: 0.5,
												color: "blue",
												weight: 0.7,
												opacity: 0.5,
												stroke: 0.1,
												dashArray: '0'
											});


											if (!L.Browser.ie && !L.Browser.opera) {
												layer6.bringToFront();
											}

											info.update(layer6.feature.properties);
										}

										function resetHighlight6(e) {
											geojson6.resetStyle(e.target);
											info.update();
										}

										function zoomToFeature6(e) {

											map.removeLayer(geojson6);
											map.removeControl(searchControl6); 

											var distid3 = parseInt(window.contid);

											window.maplevel = 3; ///// District level
													
											file_info6 = './maps/KML/1/'+distid2+'/'+distid3+'/O_'+distid3+'.js';
											load(file_info6);
											var myVariable6 = 'O_'+distid3;
											console.log(file_info6+" <<=== "+myVariable6);

											var geojson7;
											var geojson7 = new L.GeoJSON(eval(myVariable6), {
												style: function(feature) {
													return {fillColor: 'white', color: 'blue', weight: 0.5,  stroke: 0.7, fillOpacity: 0.8};
												},
												// onEachFeature: function(feature, marker) {
												//     marker.bindPopup('Name : '+feature.properties.Name+' ('+ feature.properties.DB_ID+')');
												// }
												onEachFeature: onEachFeature7
											});

											L.tileLayer('https://api.maptiler.com/maps/basic/256/{z}/{x}/{y}.png?key=088HTkVkumk1ZGlBjdvX', {
												maxZoom: 11,
												minZoom: 1,
												attribution: '',
												id: 'mapbox.light'
											}).addTo(map);

											map.fitBounds(geojson7.getBounds());

											var searchControl7 = new L.Control.Search({
												layer: geojson7,
												propertyName: 'Name',
												marker: false,
												moveToLocation: function(latlng, title, map) {
													//map.fitBounds( latlng.layer.getBounds() );
													var zoom = map.getBoundsZoom(latlng.layer.getBounds());
													map.setView(latlng, zoom); // access the zoom
												}
											});

											searchControl7.on('search:locationfound', function(e) {
												e.layer.setStyle({fillColor: 'blue', color: 'black', weight: 0.5,  stroke: 0.7, fillOpacity: 0.8});
												if(e.layer._popup)
													e.layer.openPopup();
											}).on('search:collapsed', function(e) {
												geojson7.eachLayer(function(layer) {   //restore feature color
													geojson7.resetStyle(layer);
												}); 
											});
											
											map.addControl(searchControl7);  //inizialize search control


backbut5.remove();

var backbut6 = L.easyButton({
position: 'topright',
states:[
	{
		stateName: 'states-layer',
		icon: 'fa-arrow-left',
		title: 'states',
		id: 'statesLayer',
		onClick: function(control) {
			//console.log(control);
			map.removeLayer(geojson7);
			searchControl7.remove();
			geojson6.addTo(map);
			map.addControl(searchControl6);
			map.fitBounds(geojson6.getBounds());
			backbut6.remove();
			map.addControl(backbut5);
			
		}	
	}
]
});

map.addControl(backbut6);


													function onEachFeature7(feature7, layer7) {
														layer7.on({
															mouseover: highlightFeature7,
															mouseout: resetHighlight7,
															dblclick: zoomToFeature7
														});
													}

													function highlightFeature7(e) {
														var layer7 = e.target;

														layer7.setStyle({
															fillColor: 'red',
															fillOpacity: 0.5,
															color: "blue",
															weight: 0.7,
															opacity: 0.5,
															stroke: 0.1,
															dashArray: '0'
														});


														if (!L.Browser.ie && !L.Browser.opera) {
															layer7.bringToFront();
														}

														info.update(layer7.feature.properties);
													}

													function resetHighlight7(e) {
														geojson7.resetStyle(e.target);
														info.update();
													}


													function zoomToFeature7(e) {

														map.removeLayer(geojson7);
														map.removeControl(searchControl7); 

	//// Checking City (73 Bangalore, 676 Mumbai) for Wards and Taluk Separation
	///// If City and District are same for Places like Blore,Mumbai,Chennai etc.. next level wards and ends
	///// For district level places next level Taluk (SubDist) ===> Village last level and ends
						
						if(distid3 == 73 || distid3 == 676 ) {
							var str2 = "W_"
						} else {
							var str2 = "T_"
						}

														file_info7 = './maps/KML/1/'+distid2+'/'+distid3+'/'+str2+distid3+'.js';

														load(file_info7);
														var myVariable7 = str2+distid3;
														console.log(file_info7+" <<<=== "+myVariable7);


														var geojson8;
														var geojson8 = new L.GeoJSON(eval(myVariable7), {
															style: function(feature) {
																return {fillColor: 'white', color: 'blue', weight: 0.5,  stroke: 0.7, fillOpacity: 0.8};
															},
															// onEachFeature: function(feature, marker) {
															//     marker.bindPopup('Name : '+feature.properties.Name+' ('+ feature.properties.DB_ID+')');
															// }
															onEachFeature: onEachFeature8
														});

														L.tileLayer('https://api.maptiler.com/maps/basic/256/{z}/{x}/{y}.png?key=088HTkVkumk1ZGlBjdvX', {
															maxZoom: 13,
															minZoom: 1,
															attribution: '',
															id: 'mapbox.light'
														}).addTo(map);

														map.fitBounds(geojson8.getBounds());

														var searchControl8 = new L.Control.Search({
															layer: geojson8,
															propertyName: 'Name',
															marker: false,
															moveToLocation: function(latlng, title, map) {
																//map.fitBounds( latlng.layer.getBounds() );
																var zoom = map.getBoundsZoom(latlng.layer.getBounds());
																map.setView(latlng, zoom); // access the zoom
															}
														});

														searchControl8.on('search:locationfound', function(e) {
															e.layer.setStyle({fillColor: 'blue', color: 'black', weight: 0.5,  stroke: 0.7, fillOpacity: 0.8});
															if(e.layer._popup)
																e.layer.openPopup();
														}).on('search:collapsed', function(e) {
															geojson8.eachLayer(function(layer) {   //restore feature color
																geojson8.resetStyle(layer);
															}); 
														});
														
														map.addControl(searchControl8);

														

backbut6.remove();

var backbut7 = L.easyButton({
position: 'topright',
states:[
	{
		stateName: 'states-layer',
		icon: 'fa-arrow-left',
		title: 'states',
		id: 'statesLayer',
		onClick: function(control) {
			//console.log(control);
			map.removeLayer(geojson8);
			searchControl8.remove();
			geojson7.addTo(map);
			map.addControl(searchControl7);
			map.fitBounds(geojson7.getBounds());
			backbut7.remove();
			map.addControl(backbut6);
			
		}	
	}
]
});

map.addControl(backbut7);


														function onEachFeature8(feature8, layer8) {
															layer8.on({
																mouseover: highlightFeature8,
																mouseout: resetHighlight8,
																dblclick: zoomToFeature8
															});
														}


														function highlightFeature8(e) {
															var layer8 = e.target;

															layer8.setStyle({
																fillColor: 'red',
																fillOpacity: 0.5,
																color: "blue",
																weight: 0.7,
																opacity: 0.5,
																stroke: 0.1,
																dashArray: '0'
															});


															if (!L.Browser.ie && !L.Browser.opera) {
																layer8.bringToFront();
															}

															info.update(layer8.feature.properties);
														}

														function resetHighlight8(e) {
															geojson8.resetStyle(e.target);
															info.update();
														}

														function zoomToFeature8(e) {
															map.removeLayer(geojson8);
															map.removeControl(searchControl8); 

			//// India ==> Karnataka ==> Bangalore ==> Ward Gandhi Nagar
															var distid4 = parseInt(window.contid);

															window.maplevel = 4; ///// Ward or Taluk level

						if(distid3 == 73) {
							var str3 = "W"
						} else {
							var str3 = "T"
						}
																	
															file_info8 = './maps/KML/1/'+distid2+'/'+distid3+'/'+str3+'/O_'+distid4+'.js';
															load(file_info8);
															var myVariable8 = 'O_'+distid4;
															console.log(file_info8+"<<<===="+myVariable8);

															var geojson9;
															var geojson9 = new L.GeoJSON(eval(myVariable8), {
																style: function(feature) {
																	return {fillColor: 'white', color: 'blue', weight: 0.5,  stroke: 0.7, fillOpacity: 0.8};
																},
																// onEachFeature: function(feature, marker) {
																//     marker.bindPopup('Name : '+feature.properties.Name+' ('+ feature.properties.DB_ID+')');
																// }
																onEachFeature: onEachFeature9
															});

															L.tileLayer('https://api.maptiler.com/maps/basic/256/{z}/{x}/{y}.png?key=088HTkVkumk1ZGlBjdvX', {
																maxZoom: 15,
																minZoom: 1,
																attribution: '',
																id: 'mapbox.light'
															}).addTo(map);

															map.fitBounds(geojson9.getBounds());

															var searchControl9 = new L.Control.Search({
																layer: geojson9,
																propertyName: 'Name',
																marker: false,
																moveToLocation: function(latlng, title, map) {
																	//map.fitBounds( latlng.layer.getBounds() );
																	var zoom = map.getBoundsZoom(latlng.layer.getBounds());
																	map.setView(latlng, zoom); // access the zoom
																}
															});

															searchControl9.on('search:locationfound', function(e) {
																e.layer.setStyle({fillColor: 'blue', color: 'black', weight: 0.5,  stroke: 0.7, fillOpacity: 0.8});
																if(e.layer._popup)
																	e.layer.openPopup();
															}).on('search:collapsed', function(e) {
																geojson9.eachLayer(function(layer) {   //restore feature color
																	geojson9.resetStyle(layer);
																}); 
															});
															
															map.addControl(searchControl9);

															// if(distid3 == 73) {
															//     var geojson9;
															//     geojson9 = L.geoJson(eval(myVariable8), {
															//         style: style
															//     }).addTo(map);
															//     map.fitBounds(geojson9.getBounds());
															// } else {
															//     var geojson9;
															//     geojson9 = L.geoJson(eval(myVariable8), {
															//         style: style,
															//         onEachFeature: onEachFeature9
															//     }).addTo(map);
															//     map.fitBounds(geojson9.getBounds());
															// }

backbut7.remove();

var backbut8 = L.easyButton({
position: 'topright',
states:[
	{
		stateName: 'states-layer',
		icon: 'fa-arrow-left',
		title: 'states',
		id: 'statesLayer',
		onClick: function(control) {
			//console.log(control);
			// map.removeLayer(geojson9);
			// geojson8.addTo(map);
			// map.fitBounds(geojson8.getBounds());
			// backbut8.remove();
			// map.addControl(backbut7);

			map.removeLayer(geojson9);
			searchControl9.remove();
			geojson8.addTo(map);
			map.addControl(searchControl8);
			map.fitBounds(geojson8.getBounds());
			backbut8.remove();
			map.addControl(backbut7);
			
		}	
	}
]
});

map.addControl(backbut8);

																	function onEachFeature9(feature9, layer9) {
																		layer9.on({
																			mouseover: highlightFeature9,
																			mouseout: resetHighlight9,
																			dblclick: zoomToFeature9
																		});
																	}

																	function highlightFeature9(e) {
																		var layer9 = e.target;

																		layer9.setStyle({
																			fillColor: 'red',
																			fillOpacity: 0.5,
																			color: "blue",
																			weight: 0.7,
																			opacity: 0.5,
																			stroke: 0.1,
																			dashArray: '0'
																		});


																		if (!L.Browser.ie && !L.Browser.opera) {
																			layer9.bringToFront();
																		}

																		info.update(layer9.feature.properties);
																	}


																	function resetHighlight9(e) {
																		geojson9.resetStyle(e.target);
																		info.update();
																	}


																	function zoomToFeature9(e) {

																		map.removeLayer(geojson9);
																		map.removeControl(searchControl9); 

																		var distid5 = parseInt(window.contid);

																		window.maplevel = 5; ///// Village level

																		file_info9 = './maps/KML/1/'+distid2+'/'+distid3+'/'+str3+'/V_'+distid5+'.js';
																		load(file_info9);
																		var myVariable9 = 'V_'+distid5;
																		console.log(file_info9+"<<<==="+myVariable9);

																		var geojson10;
																		var geojson10 = new L.GeoJSON(eval(myVariable9), {
																			style: function(feature) {
																				return {fillColor: 'white', color: 'blue', weight: 0.5,  stroke: 0.7, fillOpacity: 0.8};
																			},
																			// onEachFeature: function(feature, marker) {
																			//     marker.bindPopup('Name : '+feature.properties.Name+' ('+ feature.properties.DB_ID+')');
																			// }
																			onEachFeature: onEachFeature10
																		});

																		L.tileLayer('https://api.maptiler.com/maps/basic/256/{z}/{x}/{y}.png?key=088HTkVkumk1ZGlBjdvX', {
																			maxZoom: 17,
																			minZoom: 1,
																			attribution: '',
																			id: 'mapbox.light'
																		}).addTo(map);

																		map.fitBounds(geojson10.getBounds());

																		var searchControl10 = new L.Control.Search({
																			layer: geojson10,
																			propertyName: 'Name',
																			marker: false,
																			moveToLocation: function(latlng, title, map) {
																				//map.fitBounds( latlng.layer.getBounds() );
																				var zoom = map.getBoundsZoom(latlng.layer.getBounds());
																				map.setView(latlng, zoom); // access the zoom
																			}
																		});

																		searchControl10.on('search:locationfound', function(e) {
																			e.layer.setStyle({fillColor: 'blue', color: 'black', weight: 0.5,  stroke: 0.7, fillOpacity: 0.8});
																			if(e.layer._popup)
																				e.layer.openPopup();
																		}).on('search:collapsed', function(e) {
																			geojson10.eachLayer(function(layer) {   //restore feature color
																				geojson10.resetStyle(layer);
																			}); 
																		});
																		
																		map.addControl(searchControl10);


																				// var geojson10;
																				// geojson10 = L.geoJson(eval(myVariable6), {
																				//     style: style,
																				//     onEachFeature: onEachFeature10
																				// }).addTo(map);

																				// map.fitBounds(geojson10.getBounds());

backbut8.remove();

var backbut9 = L.easyButton({
position: 'topright',
states:[
	{
		stateName: 'states-layer',
		icon: 'fa-arrow-left',
		title: 'states',
		id: 'statesLayer',
		onClick: function(control) {
			//console.log(control);
			map.removeLayer(geojson10);
			searchControl10.remove();
			geojson9.addTo(map);
			map.addControl(searchControl9);
			map.fitBounds(geojson9.getBounds());
			backbut9.remove();
			map.addControl(backbut8);
			
		}	
	}
]
});

map.addControl(backbut9);

																			function onEachFeature10(feature10, layer10) {
																				layer10.on({
																					mouseover: highlightFeature10,
																					mouseout: resetHighlight10,
																					dblclick: zoomToFeature10
																				});
																			}

																			function highlightFeature10(e) {
																				var layer10 = e.target;

																				layer10.setStyle({
																					fillColor: 'red',
																					fillOpacity: 0.5,
																					color: "blue",
																					weight: 0.7,
																					opacity: 0.5,
																					stroke: 0.1,
																					dashArray: '0'
																				});


																				if (!L.Browser.ie && !L.Browser.opera) {
																					layer10.bringToFront();
																				}

																				info.update(layer10.feature.properties);
																			}


																			function resetHighlight10(e) {
																				geojson10.resetStyle(e.target);
																				info.update();
																			}


																			function zoomToFeature10(e) {

																				var distid6 = parseInt(window.contid);

																				window.maplevel = 6; ///// Village level

																				file_info6 = './maps/KML/1/'+distid2+'/'+distid3+'/'+str3+'/V/O_'+distid6+'.js';
																				
																				load(file_info6);
																				console.log(file_info6);

																				var myVariable7 = 'O_'+distid6;

																				map.removeLayer(geojson10);

																				var geojson11;
																				geojson11 = L.geoJson(eval(myVariable7), {
																					style: style
																				}).addTo(map);

																				map.fitBounds(geojson11.getBounds());


backbut9.remove();

var backbut10 = L.easyButton({
position: 'topright',
states:[
{
	stateName: 'states-layer',
	icon: 'fa-arrow-left',
	title: 'states',
	id: 'statesLayer',
	onClick: function(control) {
		//console.log(control);
		map.removeLayer(geojson11);
		geojson10.addTo(map);
		map.fitBounds(geojson10.getBounds());
		backbut10.remove();
		map.addControl(backbut9);
		
	}	
}
]
});

map.addControl(backbut10);
																				



																			}


																	}




														}



													}




										}


									}


						}

					}       

			}

///////// Ends India Level Code


///////// Starts USA Country Level Code Code 233
//console.log(window.contid + "<<<==== " + window.maplevel);

			else if (window.contid == 207  && window.maplevel == 0) { 

					map.removeLayer(geojson2);

					load('./maps/KML/207/O-207.js');

						maplevel = 1; ///// Country level

						var geojson3;

						geojson3 = L.geoJson(USOutline, {
							style: style,
							onEachFeature: onEachFeature3
						}).addTo(map);

						map.fitBounds(geojson3.getBounds());


///// Starts Back button2

backbut1.remove();

var backbut2 = L.easyButton({
position: 'topright',
states:[
{
	stateName: 'countries-layer',
	icon: 'fa-arrow-left',
	title: 'countries',
	id: 'countriesLayer',
	onClick: function(control) {
		//console.log(control);
		map.removeLayer(geojson3);
		geojson2.addTo(map);
		window.maplevel = 0;
		map.fitBounds(geojson2.getBounds());
		backbut2.remove();
		map.addControl(backbut1);
		
	}	
}
]
});

map.addControl(backbut2);

///// Ends Back button2



						function onEachFeature3(feature3, layer3) {
							layer3.on({
								mouseover: highlightFeature3,
								mouseout: resetHighlight3,
								dblclick: zoomToFeature3
							});

							function highlightFeature3(e) {
								var layer3 = e.target;

								layer3.setStyle({
									fillColor: 'red', 
									fillOpacity: 0.5,  
									color: "blue",
									weight: 0.7,
									opacity: 0.5,
									stroke: 0.1,
									dashArray: '0'
								});


								if (!L.Browser.ie && !L.Browser.opera) {
									layer3.bringToFront();
								}

								info.update(layer3.feature.properties);
							}

							function resetHighlight3(e) {
								geojson3.resetStyle(e.target);
								info.update();
							}

							function zoomToFeature3(e) {
								map.removeLayer(geojson3);

								load('./maps/KML/207/S-207.js');

								var geojson4;

								geojson4 = L.geoJson(USStates, {
									style: style,
									onEachFeature: onEachFeature4
								}).addTo(map);

								map.fitBounds(geojson4.getBounds());

///// Starts Back button3
backbut2.remove();

var backbut3 = L.easyButton({
position: 'topright',
states:[
{
	stateName: 'states-layer',
	icon: 'fa-arrow-left',
	title: 'states',
	id: 'statesLayer',
		onClick: function(control) {
			//console.log(control);
			map.removeLayer(geojson4);
			geojson3.addTo(map);
			map.fitBounds(geojson3.getBounds());
			backbut3.remove();
			map.addControl(backbut2);
			
		}	
}
]
});

map.addControl(backbut3);
///// Ends Back button3




								function onEachFeature4(feature4, layer4) {
									layer4.on({
										mouseover: highlightFeature4,
										mouseout: resetHighlight4,
										dblclick: zoomToFeature4
									});
								}

								function highlightFeature4(e) {
									var layer4 = e.target;

									layer4.setStyle({
										fillColor: 'red', 
										fillOpacity: 0.5,  
										color: "blue",
										weight: 0.7,
										opacity: 0.5,
										stroke: 0.1,
										dashArray: '0'
									});


									if (!L.Browser.ie && !L.Browser.opera) {
										layer4.bringToFront();
									}

									info.update(layer4.feature.properties);
								}

								function resetHighlight4(e) {
									geojson4.resetStyle(e.target);
									info.update();
								}

								function zoomToFeature4(e) {
									alert(window.contid);
								}
							}
						
						}

			}

			else {
				// alert("No Country Selected !!!");
			}

///// Ends USA Country Level Code

		}

		///// Ends Country Level Code


	}

	var geojson;

	geojson = L.geoJson(worldOutline, {
		style: style,
		onEachFeature: onEachFeature
	}).addTo(map);

	L.tileLayer('https://api.maptiler.com/maps/basic/256/{z}/{x}/{y}.png?key=088HTkVkumk1ZGlBjdvX', {
		maxZoom: 3,
		minZoom: 1,
		attribution: '',
		id: 'mapbox.light'
	}).addTo(map);

	function onEachFeature(feature, layer) {
		layer.on({
			mouseover: highlightFeature,
			mouseout: resetHighlight,
			dblclick: zoomToFeature
		});
	}

	//map.attributionControl.addAttribution('Population data &copy; <a href="http://census.gov/">US Census Bureau</a>');
	map.attributionControl.addAttribution('');




	// L.control.custom({
	//         position: 'topleft',
	//         content: '<button type="button" style="width:80%; padding-left:0.3rem; padding-right:0.3rem;" class="btn btn-warning">' +
	//             '    <i class="fa fa-crosshairs"></i>' +
	//             '</button>' +
	//             '<button type="button" style="width:80%; padding-left:0.3rem; padding-right:0.3rem;" class="btn btn-info">' +
	//             '    <i class="fa fa-compass"></i>' +
	//             '</button>' +
	//             '<button type="button" style="width:80%; padding-left:0.3rem; padding-right:0.3rem;" class="btn btn-primary">' +
	//             '    <i class="fa fa-spinner fa-pulse fa-fw"></i>' +
	//             '</button>' +
	//             '<button type="button" style="width:80%; padding-left:0.3rem; padding-right:0.3rem;" class="btn btn-danger">' +
	//             '    <i class="fa fa-times"></i>' +
	//             '</button>' +
	//             '<button type="button" style="width:80%; padding-left:0.3rem; padding-right:0.3rem;" class="btn btn-success">' +
	//             '    <i class="fa fa-check"></i>' +
	//             '</button>' +
	//             '<button type="button" style="width:80%; padding-left:0.3rem; padding-right:0.3rem;" class="btn btn-warning">' +
	//             '    <i class="fa fa-exclamation-triangle"></i>' +
	//             '</button>',
	//         classes: 'btn-group-vertical btn-group-sm',
	//         style: {
	//             margin: '15px',
	//             float: 'center',
	//             padding: '0px 0 0 0',
	//             cursor: 'pointer'
	//         },
	//         datas: {
	//             'foo': 'bar',
	//         },
	//         events: {
	//             click: function(data) {
	//                 alert("yessssss");
	//                 console.log('wrapper div element clicked');
	//                 console.log(data);
	//             },
	//             dblclick: function(data) {
	//                 alert("Nooooooooooo");
	//                 console.log('wrapper div element dblclicked');
	//                 console.log(data);
	//             },
	//             contextmenu: function(data) {
	//                 alert("ZZZZZZZZZZZZZZ");
	//                 console.log('wrapper div element contextmenu');
	//                 console.log(data);
	//             },
	//         }
	//     })
	//     .addTo(map);

	// L.control.custom({
	//         position: 'topleft',
	//         content: '<div class="input-group">' +
	//             '    <input type="text" id="selcity" class="form-control input-sm" placeholder="Search">' +
	//             '    <span class="input-group-btn">' +
	//             '        <button id="gocity" class="form-control" style="width:80%; padding-left:0.5rem;" type="button">Go</button>' +
	//             '    </span>' +
	//             '</div>',
	//         classes: '',
	//         style: {
	//             position: 'absolute',
	//             left: '50px',
	//             top: '0px',
	//             width: '200px',
	//         },
	//     })
	//     .addTo(map);

	// L.control.custom({
	//         position: 'bottomleft',
	//         content: '<div class="panel-body">' +
	//             '    <div class="progress" style="margin-bottom:0px;">' +
	//             '        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="41" ' +
	//             '             aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: 91%">' +
	//             '            91% Completed' +
	//             '        </div>' +
	//             '    </div>' +
	//             '</div>',
	//         classes: 'panel panel-default',
	//         style: {
	//             width: '200px',
	//             margin: '20px',
	//             padding: '0px',
	//         },
	//     })
	//     .addTo(map);

	// L.control.custom({
	//     position: 'bottomright',
	//     content : '<img src="http://lorempixel.com/105/105/" class="img-thumbnail" id="demoImage">',
	//     classes : '',
	//     style   :
	//     {
	//         margin: '0px 20px 20px 0',
	//         padding: '0px',
	//     },
	// })
	// .addTo(map);

	// L.control.custom({
	//     position: 'bottomright',
	//     content : '<button class="btn btn-default btn-sm" id="changeImg">'+
	//                 '    <i class="fa fa-refresh"></i> Change Image'+
	//                 '</button>',
	//     classes : '',
	//     style   :
	//     {
	//         margin: '5px 20px',
	//         padding: '0px',
	//     },
	// })
	// .addTo(map);
</script>