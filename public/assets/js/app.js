class App {
  constructor() {
    this.baseUrl = document.querySelector('meta[name=base-url]')?.content;
  }

  /**
   * Set route url
   *
   * @param {string} to
   * @param {array} [parameters=[]]
   * 
   * @memberof App
   * 
   * @returns {string}
   */
  route = (to, parameters = []) => {
    let url = `${this.baseUrl}?route=${to}`;

    if (parameters.length > 0) {
      url += parameters.map((param) => `&${param.key}=${param.value}`).join('');
    }

    return url.trim();
  }
}

export default App;