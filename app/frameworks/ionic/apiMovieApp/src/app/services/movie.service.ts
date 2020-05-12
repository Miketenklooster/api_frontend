import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';

// Typescript custom enum for search types (optional)
export enum SearchType {
  all = '',
  movie = 'movie',
  series = 'series',
  episode = 'episode'
}

@Injectable({
  providedIn: 'root'
})

export class MovieService {
  // Auto login with these params
  // Base64 encoded
  // bWlrZToxMjM=
  // url = 'http://www.omdbapi.com/';
  url = 'http://localhost:8000/api/v8';
  apiKey =  sessionStorage.getItem('bearer_token');
  /**
   * Constructor of the Service with Dependency Injection
   * @param http The standard Angular HttpClient to make requests
   */
  constructor(private http: HttpClient) { }

  autoLogin() {
    return this.http.get(this.url + '/login', {
      headers: {
        'Content-Type': 'application/json',
        Authorization: 'Basic ' + 'bWlrZToxMjM='
      }
    }).pipe(
        map(results => results['message'])
    ).pipe(
        map((result) => {
          sessionStorage.setItem('bearer_token', result.access_token);
        })
    );
  }
  /**
   * Get data from the api
   * map the result to return only the results that we need
   *
   * @param {string} title Search Term
   * @param {SearchType} type movie, series, episode or empty
   * @returns Observable with the search results
   */
  // title: string, type: SearchType
  searchData(title: string, type: SearchType): Observable<any> {
    this.autoLogin();
    return this.http.get(this.url + '/movie', {
      headers: {
        'Content-Type': 'application/json',
        Authorization: 'Bearer ' + this.apiKey
      }
    }).pipe(
        map(results => results['message'])
    ).pipe(
        map((result) => {
          sessionStorage.setItem('bearer_token', result.access_token);
        })
    );
  }

  /**
   * Get the detailed information for an ID using the "i" parameter
   *
   * @param {string} id imdbID to retrieve information
   * @returns Observable with detailed information
   */
  getDetails(id) {
    return this.http.get(`${this.url}/movie/${id}`, {
      headers: {
        'Content-Type': 'application/json',
        Authorization: 'Bearer ' + this.apiKey
      }
    }).pipe(
        map(results => results['message'])
    ).pipe(
        map((result) => {
          sessionStorage.setItem('bearer_token', result.access_token);
        })
    );
    // return this.http.get(`${this.url}?i=${id}&plot=full&apikey=${this.apiKey}`);
  }
}
