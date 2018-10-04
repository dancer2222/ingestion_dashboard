class ProvidersList extends React.Component {
    render() {
        const { list, urlToProvider } = this.props;
        let listItems = null;

        if (list instanceof Array) {
            listItems = list.map(function (item) {
                const { id, name, qa_batch } = item;
                let media_type = {title: 'undefined'};

                if (qa_batch != null && qa_batch.hasOwnProperty('media_type')) {
                    media_type['title'] = qa_batch.media_type.title;
                }

                return (
                    <tr key={id} style={{cursor: 'pointer'}}>
                        <td>
                            <a href={urlToProvider + '/' + id} className='font-weight-bold text-dark'>{ id }</a>
                        </td>
                        <td>
                            <a href={urlToProvider + '/' + id} className='font-weight-bold text-dark'>{ name }</a>
                        </td>
                        <td>
                            <span className="badge badge-info">{ media_type.title }</span>
                        </td>
                    </tr>
                )
            });
        }

        return (
            <div className={'position-relative '}>
                <React.Fragment>
                    <table className={'table table-hover mt-3 ' + (list.length > 0 ? '' : 'd-none')}>
                        <thead className="thead-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Media type</th>
                        </tr>
                        </thead>

                        <tbody>
                        { listItems }
                        </tbody>
                    </table>
                </React.Fragment>
            </div>
        )
    }
}

class ProviderRoot extends React.Component {
    constructor(props) {
        super(props);

        this.timeout = null;
        this.state = {
            providersList: [],
            isLoading: false,
            providerId: this.props.providerId,
            formData: {},
            needToReload: false,
        };

        this.loadProviderList.bind(this);
    }

    loadProviderList = (e, noWait) => {
        const self = this;
        const formData = new FormData(e.target.closest('form'));

        this.setState({formData: formData});

        clearTimeout(this.timeout);

        if (noWait) {
            this.fetchProvidersList(formData, self);
        } else {
            this.timeout = setTimeout(function () {
                self.fetchProvidersList(formData, self);
            }, 1000);
        }
    }

    onLoadProvider = (providerId, providerName) => {
        this.setState({
            providerId: providerId,
            providerName: providerName,
        });
    }

    fetchProvidersList = (formData, context) => {
        context.setState({
            isLoading: true
        });

        axios({
            url: context.props.urlProvidersList,
            method: 'get',
            params: {
                list: formData.get('list'),
                needle: formData.get('needle')
            }
        }).then(list => {
            context.setState({
                isLoading: false,
                providersList: list.data,
                needToReload: false
            });
        }).catch((error) => {
            context.setState({
                isLoading: false,
                needToReload: true
            });
        });
    }

    render() {
        return (
            <React.Fragment>
                <ProvidersSearchForm onChangeForm={this.loadProviderList} />

                {
                    this.state.needToReload ?
                        <div>
                            <span className='text-danger'>An error happened. Try again or refresh page.</span>
                        </div> :
                        null
                }

                <div className="card-body">
                    <ProvidersList list={this.state.providersList} urlToProvider={this.props.urlToProvider} onLoadProvider={this.onLoadProvider} />
                </div>

                <div className={"overlay "  + (!this.state.isLoading ? 'd-none' : '')}>
                    <div className="overlay__inner">
                        <div className="overlay__content">
                            <div className={"lds-roller "}>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </React.Fragment>
        )
    }
}

class ProvidersSearchForm extends React.Component {
    constructor(props) {
        super(props);
        this.state = {isList: false};
        this.needle = React.createRef()
    }

    onNeedleChange = (e) => {
        this.setState({isList: false});
        this.props.onChangeForm(e);
    }

    onLoadFullList = (e) => {
        this.needle.current.value = '';
        this.setState({isList: !this.state.isList});

        if (!this.state.isList) {
            this.props.onChangeForm(e);
        }
    }

    forceSubmit = (e) => {
        e.preventDefault();
        this.props.onChangeForm(e, true);
    }

    render() {
        return (
            <form action="" method="get" id="providersSearchForm" onChange={this.onChangeForm} onSubmit={this.forceSubmit}>

                <div className="input-group mb-1">
                    <input type="text" className="form-control rounded-left mb-2 drawBorder"
                           id="providerNeedle" name="needle"
                           placeholder="Provider name or ID" aria-label="needle" aria-describedby="providerNeedleSubmit"
                           defaultValue="" onChange={this.onNeedleChange} ref={this.needle} />

                        <div className="input-group-append">
                            <button type="submit" className="btn btn-primary pl-4 pr-4 mb-2" id="providerNeedleSubmit">
                                Find
                            </button>
                        </div>
                </div>

                <div className="float-left">
                    <div className="custom-control custom-checkbox custom-control-inline">
                        <input type="checkbox" className="custom-control-input" id="list"
                               onChange={this.onLoadFullList} checked={this.state.isList} value='list' name="list" />
                        <label className="custom-control-label" htmlFor="list">
                            Full list
                        </label>
                    </div>
                </div>

            </form>
        )
    }
}

class Provider extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            provider: null,
            providerContentList: {},
            providerId: this.props.providerId,
            isLoading: false,
            currentPage: 1,
            mediaType: null
        };
    }

    componentDidMount() {
        this.loadProviderContent(1);
    }

    loadProviderContent = (page) => {
        this.setState({
            isLoading: true
        });

        page = page ? page : this.state.currentPage;

        axios({
            url: this.props.urlToProvider + '/' + this.state.providerId,
            method: 'get',
            params: {
                page: page,
                mediaType: this.state.mediaType
            }
        }).then(result => {
            if (!result.data.hasOwnProperty('list') && result.data.hasOwnProperty('mediaType')) {
                return false;
            }

            this.setState({
                isLoading: false,
                providerContentList: result.data.list,
                mediaType: result.data.mediaType,
                provider: result.data.provider
            });
        }).catch((error) => {
            this.setState({
                isLoading: false
            });
        });
    }

    onListChanged = (data) => {
        const { currentPage } = data;

        if (currentPage === this.state.currentPage) {
            return null;
        }

        this.setState({
            currentPage: currentPage
        });

        this.loadProviderContent(currentPage);
    }

    render() {
        const { isLoading, providerContentList, mediaType, provider } = this.state;
        const { urlToContentSearch } = this.props;
        let list = null;

        if (providerContentList instanceof Object && Object.keys(providerContentList).length && providerContentList.data.length > 0) {
            list = providerContentList.data.map(function (item) {
                return(
                    <tr key={item.id}>
                        <th scope="row">{item.id}</th>
                        <td>
                            <a href={urlToContentSearch + '/' + mediaType + '/' + item.id}>
                                {item.title}
                            </a>
                        </td>
                        <td>{item.status}</td>
                    </tr>
                )
            });
        }

        return(
            <React.Fragment>
                <div>
                    <a href={this.props.urlProvidersList} className='btn btn-info'>
                        Back to providers
                    </a>
                </div>

                <div className='position-relative mt-3' style={{minHeight: '100px'}}>

                    {
                        !isLoading && list === null ?
                            <div>
                                <div className="alert alert-danger alert-dismissible fade show" role="alert">
                                    Can't find any contents by this provider.
                                    <button type="button" className="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>:
                            null
                    }

                    {
                        list ?
                        <div>
                            <table className="table table-hover">
                                <thead className="thead-dark">
                                <tr>
                                    <th colSpan={3}>
                                        Provider: {provider.name} | Total { mediaType }: { providerContentList.total }
                                    </th>
                                </tr>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                { list }
                                </tbody>
                            </table>

                            <div className="d-flex flex-row py-4 align-items-center">
                                <Pagination totalRecords={providerContentList.total}
                                    pageLimit={providerContentList.per_page}
                                    pageNeighbours={3}
                                    onPageChanged={this.onListChanged.bind(this)} />
                            </div>
                        </div> :
                            null
                    }

                    <div className={"overlay "  + (!isLoading ? 'd-none' : '')}>
                        <div className="overlay__inner">
                            <div className="overlay__content">
                                <div className={"lds-roller "}>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </React.Fragment>
        )
    }
}

const root = document.getElementById('providers-root');

// Initial props for components
const providerId = root.getAttribute('data-provider-id');
const urlProvidersList = root.getAttribute('data-url-list');
const urlToProvider = root.getAttribute('data-url-provider-item');
const urlToContentSearch = root.getAttribute('data-url-content-search');
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Settings for post requests
axios.defaults.headers['X-CSRF-TOKEN'] = csrfToken;
axios.defaults.headers.get['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.get['Content-Type'] = 'application/json';

ReactDOM.render(
    <React.Fragment>
        {
            providerId ?
                <Provider providerId={providerId} urlToProvider={urlToProvider} urlProvidersList={urlProvidersList} urlToContentSearch={urlToContentSearch} />:
                <ProviderRoot urlProvidersList={urlProvidersList} urlToProvider={urlToProvider} csrfToken={csrfToken} providerId={providerId}/>
        }
    </React.Fragment>,
    root
);